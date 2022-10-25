<?php

namespace App\Http\Livewire;

use App\Models\CancelOrder;
use App\Models\Customers;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentType;
use App\Models\Room;
use App\Models\Table;
use App\Traits\WithPrinting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveModalHandleFbTableOrder extends Component
{
    use WithPrinting;

    public $fnbSearch = '';
    public $customerSearch = '';

    // Table room Column Fills
    public $table_id;
    public $table_type_id;
    public $table_name;

    public $room_no;

    // Order table Column Fills
    public $order_id;
    public $invoice_no;
    public $pax = 1;
    public $sub_total = 0;
    public $discount_percent = 0;
    public $discount_amount = 0;
    public $payment_type_id;
    public $is_paid;
    public $customer_id;
    public $inhouse_id;
    public $cashier;
    public $created_at;

    // Customer table Column Fills
    public $customer_name;
    public $discount = 0;

    // Collections & Filters
    public $categories;
    public $selectedCategoryId;
    public $foodTypes;
    public $selectedFoodTypeId;
    public $paymentTypes;
    // public $selectedPaymentTypeId;

    // States
    public $editingItem = [];
    public $remark = '';
    public $confirmingItem = [];
    public $orderDetails = [];
    public $order_time = 0;
    public $isDirty = false;
    public $isModalDirty = false;
    public $orderTimeSelectedForPrinting = 1;
    public $printKitchenOrder = true;

    public $showHandleTableOrderModal = false;
    public $showRemarkInputModal = false;
    public $showOrderDeleteModal = false;
    public $showDeleteConfirmationModal = false;
    public $showClearTableConfirmationModal = false;
    public $showKitchenOrderPrintModal = false;

    protected $listeners = ['createOrder'];

    // public function printSelectedKitchenPrintTypeOrders()
    // {
    //     if ($this->printKitchenOrder) {
    //         return $this->printKitchenOrder($this->orderTimeSelectedForPrinting);
    //     } else {
    //         $cancelOrders = CancelOrder::with('food:id,food_name')->where('invoice_no', $this->invoice_no)->where('order_time', $this->orderTimeSelectedForPrinting)->get();

    //         $data = [
    //             'date' => Carbon::parse($this->created_at)->format('d-m-y'),
    //             'time' => Carbon::parse($this->created_at)->format('g:i A'),
    //             'table_name' => $this->table_name,
    //             'cashier' => $this->cashier,
    //             'invoice_no' => $this->invoice_no,
    //             'order_time' => $this->orderTimeSelectedForPrinting,
    //             'cancel_orders' => $cancelOrders
    //         ];

    //         $date = [];
    //         $this->editingItem = [];
    //         return $this->printToPDF('pdf.all-kitchen-cancel-order-pdf', $data, $date, 'All-Kitchen-Cancel-Order', 'P');
    //     }
    // }

    public function showKitchenOrderPrintModal()
    {
        $this->showKitchenOrderPrintModal = true;
    }

    public function printBill()
    {
        $commercial_tax = round($this->sub_total / 21);
        $data = [
            'date' => Carbon::parse($this->created_at)->format('d-m-y'),
            'time' => Carbon::parse($this->created_at)->format('g:i A'),
            'table_name' => $this->table_name,
            'cashier' => $this->cashier,
            'invoice_no' => $this->invoice_no,
            'pax' => $this->pax,
            'customer' => empty($this->customerSearch) ? 'Walk-In' : $this->customerSearch,
            'sub_total' => $this->sub_total - $commercial_tax,
            'commercial_tax' => $commercial_tax,
            'discount' => $this->discount,
            'total' => $this->sub_total - $this->discount_amount,
            'order_details' => $this->orderDetails
        ];

        $date = [];
        $this->editingItem = [];
        return $this->printToPDF('pdf.table-bill-pdf', $data, $date, 'Bill', 'P');
    }

    public function printPreBill()
    {
        $commercial_tax = round($this->sub_total / 21);
        $data = [
            'date' => Carbon::parse($this->created_at)->format('d-m-y'),
            'time' => Carbon::parse($this->created_at)->format('g:i A'),
            'table_name' => $this->table_name,
            'cashier' => $this->cashier,
            'invoice_no' => $this->invoice_no,
            'pax' => $this->pax,
            'customer' => empty($this->customerSearch) ? 'Walk-In' : $this->customerSearch,
            'sub_total' => $this->sub_total - $commercial_tax,
            'commercial_tax' => $commercial_tax,
            'discount' => $this->discount,
            'total' => $this->sub_total - $this->discount_amount,
            'order_details' => $this->orderDetails
        ];

        $date = [];
        $this->editingItem = [];
        return $this->printToPDF('pdf.table-pre-bill-pdf', $data, $date, 'Pre-Bill', 'P');
    }

    public function printKitchenCancelOrder()
    {
        $data = [
            'table_name' => $this->table_name,
            'invoice_no' => $this->invoice_no,
            'food_name' => $this->editingItem['food_name'],
            'order_time' => $this->editingItem['order_time'],
            'qtyForReduction' => $this->editingItem['qtyForReduction'],
            'cashier' => $this->cashier
        ];

        $date = [];
        $this->editingItem = [];
        return $this->printToPDF('pdf.kitchen-cancel-order-pdf', $data, $date, 'Kitchen-Cancel-Order', 'P');
    }

    public function printKitchenOrder($order_time = null)
    {
        if (is_null($order_time)) {
            $order_time = $this->order_time;
        }
        $currentOrders = array_filter($this->orderDetails, function ($item) use ($order_time) {
            return $item['order_time'] == $order_time;
        });

        $data = [
            'table_name' => $this->table_name,
            'invoice_no' => $this->invoice_no,
            'cashier' => $this->cashier,
            'order_time' => $order_time,
            'order_details' => array_values($currentOrders)
        ];
        $date = [];
        // return $this->printToPDF('pdf.kitchen-order-pdf', $data, $date, 'Kitchen-Order', 'P');
        return $this->printToPDF('pdf.kitchen-order-pdf', $data, $date, 'Kitchen-Order', 'P');
    }

    public function confirmClearTable()
    {
        if ($this->order_id) {
            Order::find($this->order_id)->update([
                'cashier' => auth()->user()->name,
                'is_paid' => true,
                'is_occupied' => false,
                'updated_user_id' => auth()->id()
            ]);

            $this->emit('tableCleared');
            $this->showHandleTableOrderModal = false;
        }
    }

    public function clearTable()
    {
        $this->showClearTableConfirmationModal = true;
    }

    public function placeOrder()
    {
        if ($this->order_id) { // Existing order
            $filtered = array_filter($this->orderDetails, function ($item) {
                return $item['id'] == null;
            });

            $order = Order::find($this->order_id);

            foreach ($filtered as $item) {
                $this->sub_total += $item['amount'];
            }

            if ($this->discount) {
                $this->discount_amount = $this->sub_total * $this->discount / 100;
            }

            $order->update([
                'sub_total' => $this->sub_total,
                // 'discount_amount' => $this->discount_amount,
            ]);

            $orderDetails = $order->orderDetails->sortBy('order_time');
            $this->order_time = $orderDetails->last()->order_time + 1;

            foreach ($filtered as $item) {
                $order->orderDetails()->create([
                    'invoice_no' => $order->invoice_no,
                    'order_time' => $this->order_time,
                    'food_id' => $item['food_id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'remark' => $item['remark'],
                ]);
            }

            $this->fill($order);

            $orderDetails = $order->orderDetails()->where('order_time', $this->order_time)->get();

            $this->orderDetails = [];
            foreach ($orderDetails as $orderDetail) {
                array_push($this->orderDetails, [
                    'id' => $orderDetail->id,
                    'order_time' => $orderDetail->order_time,
                    'food_id' => $orderDetail->food_id,
                    'food_name' => $orderDetail->food->food_name,
                    'qty' => $orderDetail->qty,
                    'price' => $orderDetail->price,
                    'amount' => $orderDetail->qty * $orderDetail->price,
                    'remark' => $orderDetail->remark
                ]);
            }

            $this->isDirty = false;
            $this->emit('orderPlaced');
            return $this->printKitchenOrder();
        } else { // New order
            foreach ($this->orderDetails as $item) {
                $this->sub_total += $item['amount'];
            }

            if ($this->discount) {
                $this->discount_amount = $this->sub_total * $this->discount / 100;
            }

            $order = Order::create([
                'invoice_no' => null,
                'table_id' => $this->table_id,
                // 'pax' => $this->pax,
                // 'cashier' => auth()->user()->name,
                'sub_total' => $this->sub_total,
                // 'discount_percent' => $this->discount,
                // 'discount_amount' => $this->discount_amount,
                // 'payment_type_id' => $this->payment_type_id,
                'is_paid' => false,
                // 'is_occupied' => true,
                // 'customer_id' => $this->customer_id,
                'inhouse_id' => $this->inhouse_id,
                'operation_date' => app('OperationDate'),
                'created_user_id' => auth()->id()
            ]);

            foreach ($this->orderDetails as $item) {
                $order->orderDetails()->create([
                    'invoice_no' => $order->invoice_no,
                    'order_time' => $item['order_time'],
                    'food_id' => $item['food_id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'remark' => $item['remark'],
                ]);
            }

            $this->fill($order);
            $this->order_id = $order->id;

            $orderDetails = $order->orderDetails->sortBy('order_time');
            $this->order_time = $orderDetails->last()->order_time;
            $this->orderDetails = [];
            foreach ($orderDetails as $orderDetail) {
                array_push($this->orderDetails, [
                    'id' => $orderDetail->id,
                    'order_time' => $orderDetail->order_time,
                    'food_id' => $orderDetail->food_id,
                    'food_name' => $orderDetail->food->food_name,
                    'qty' => $orderDetail->qty,
                    'price' => $orderDetail->price,
                    'amount' => $orderDetail->qty * $orderDetail->price,
                    'remark' => $orderDetail->remark
                ]);
            }

            $this->isDirty = false;
            $this->emit('orderPlaced');
            // $this->showHandleTableOrderModal = false;
            return $this->printKitchenOrder();
        }
    }

    // public function updatedPaymentTypeId()
    // {
    //     $validated = $this->validate([
    //         'payment_type_id' => 'required|integer|numeric'
    //     ]);

    //     if (isset($this->order_id)) {
    //         Order::find($this->order_id)->update([
    //             'payment_type_id' => $validated['payment_type_id']
    //         ]);
    //     }
    // }

    // public function updatedPax()
    // {
    //     $validated = $this->validate([
    //         'pax' => 'required|integer|numeric|min:1'
    //     ]);
    //     if (isset($this->order_id)) {
    //         Order::find($this->order_id)->update([
    //             'pax' => $validated['pax']
    //         ]);
    //     }
    // }

    // public function updatedDiscountAmount()
    // {
    //     if (isset($this->order_id)) {
    //         Order::find($this->order_id)->update([
    //             'discount_amount' => $this->discount_amount
    //         ]);
    //     }
    // }

    // public function selectCustomer(Customers $customer)
    // {
    //     $this->fill($customer);
    //     $this->customer_id = $customer->id;
    //     $this->customerSearch = $customer->customer_name;
    //     $this->discount_percent = $customer->discount;

    //     if (isset($customer->discount) && isset($this->order_id)) {
    //         $this->discount_amount = round($this->sub_total * $this->discount / 100, 2);
    //         Order::find($this->order_id)->update([
    //             'discount_percent' => $this->discount_percent,
    //             'discount_amount' => $this->discount_amount,
    //             'customer_id' => $customer->id,
    //             'updated_user_id' => auth()->id(),
    //         ]);
    //     } else {
    //         $this->discount_amount = round($this->sub_total * $this->discount / 100, 2);
    //         if (isset($this->order_id)) {
    //             Order::find($this->order_id)->update([
    //                 'discount_percent' => $this->discount_percent,
    //                 'discount_amount' => $this->discount_amount,
    //                 'customer_id' => $customer->id,
    //                 'updated_user_id' => auth()->id(),
    //             ]);
    //         }
    //     }
    // }

    // On order item delete/reduce
    // public function delete()
    // {
    //     $this->showDeleteConfirmationModal = false;

    //     $qtyForReduction = $this->editingItem['qtyForReduction'];
    //     $cancellingQty = $this->editingItem['qty'] - $qtyForReduction;

    //     if ($cancellingQty > 0) {
    //         DB::transaction(function () use ($cancellingQty) {
    //             CancelOrder::create([
    //                 'order_detail_id' => $this->editingItem['id'],
    //                 'food_id' => $this->editingItem['food_id'],
    //                 'invoice_no' => $this->invoice_no,
    //                 'order_time' => $this->editingItem['order_time'],
    //                 'cancelled_quantity' => $this->editingItem['qtyForReduction'],
    //                 'created_user_id' => auth()->id()
    //             ]);

    //             OrderDetail::find($this->editingItem['id'])->update([
    //                     'qty' => $cancellingQty,
    //             ]);
    //             $lastQty = $this->orderDetails[$this->editingItem['index']]['qty'];
    //             $deductingAmount = $this->editingItem['qtyForReduction'] * $this->orderDetails[$this->editingItem['index']]['price'];

    //             $newSubtotal = $this->sub_total - $deductingAmount;
    //             $this->discount_amount = round($newSubtotal * $this->discount / 100, 2);

    //             $order = Order::find($this->order_id);
    //             $order->update([
    //                 'sub_total' => $newSubtotal,
    //                 'discount_amount' => $this->discount_amount
    //             ]);
    //             $order->refresh();

    //             $this->fill($order);

    //             $this->orderDetails[$this->editingItem['index']]['qty'] = $cancellingQty;
    //             $this->orderDetails[$this->editingItem['index']]['amount'] = $cancellingQty * $this->orderDetails[$this->editingItem['index']]['price'];
    //         });
    //         return $this->printKitchenCancelOrder();
    //     } else {
    //         DB::transaction(function () {
    //             CancelOrder::create([
    //                 'order_detail_id' => $this->editingItem['id'],
    //                 'food_id' => $this->editingItem['food_id'],
    //                 'invoice_no' => $this->invoice_no,
    //                 'order_time' => $this->editingItem['order_time'],
    //                 'cancelled_quantity' => $this->editingItem['qtyForReduction'],
    //                 'created_user_id' => auth()->id()
    //             ]);

    //             OrderDetail::find($this->editingItem['id'])->delete();

    //             $deductingAmount = $this->orderDetails[$this->editingItem['index']]['price'] * $this->orderDetails[$this->editingItem['index']]['qty'];

    //             $newSubtotal = $this->sub_total - $deductingAmount;
    //             $this->discount_amount = round($newSubtotal * $this->discount / 100, 2);

    //             $order = Order::find($this->order_id);
    //             $order->update([
    //                 'sub_total' => $newSubtotal,
    //                 'discount_amount' => $this->discount_amount
    //             ]);
    //             $order->refresh();

    //             $this->fill($order);


    //             unset($this->orderDetails[$this->editingItem['index']]);
    //             $this->orderDetails = array_values($this->orderDetails);
    //         });
    //         return $this->printKitchenCancelOrder();
    //     }
    // }

    // public function confirmDelete()
    // {
    //     $this->showOrderDeleteModal = false;

    //     $food_name = ucwords($this->editingItem['food_name']);
    //     $qtyForReduction = $this->editingItem['qtyForReduction'];
    //     $cancellingQty = $this->editingItem['qty'] - $qtyForReduction;

    //     if ($cancellingQty > 0) {
    //         $this->confirmingItem['message'] = "Are you sure you want to cancel $qtyForReduction quantity for $food_name ?";
    //     } else {
    //         $this->confirmingItem['message'] = "Are you sure you want to delete the $food_name Order ?";
    //     }

    //     $this->showDeleteConfirmationModal = true;
    // }

    // public function reduceQty($isAddition = true)
    // {
    //     if ($isAddition) {
    //         if ($this->editingItem['qtyForReduction'] < $this->editingItem['qty']) {
    //             $this->editingItem['qtyForReduction']++;
    //             $this->isModalDirty = true;
    //         }
    //     } else {
    //         if ($this->editingItem['qtyForReduction'] > 1) {
    //             $this->editingItem['qtyForReduction']--;
    //             $this->isModalDirty = true;
    //         }
    //     }
    // }

    // public function showOrderDelete($index)
    // {
    //     $this->isModalDirty = true;

    //     $this->editingItem['index'] = $index;
    //     $this->editingItem['id'] = $this->orderDetails[$index]['id'];
    //     $this->editingItem['food_id'] = $this->orderDetails[$index]['food_id'];
    //     $this->editingItem['food_name'] = $this->orderDetails[$index]['food_name'];
    //     $this->editingItem['order_time'] = $this->orderDetails[$index]['order_time'];
    //     $this->editingItem['qty'] = $this->orderDetails[$index]['qty'];
    //     $this->editingItem['qtyForReduction'] = 1;


    //     $this->showOrderDeleteModal = true;
    // }
    // End of order item delete/reduce

    public function saveRemark()
    {
        $validated = $this->validate([
            'remark' => 'required|string|min:6'
        ]);
        $this->orderDetails[$this->editingItem['index']]['remark'] = $validated['remark'];
        $this->reset(['remark', 'editingItem', 'showRemarkInputModal']);
    }

    public function addRemark($index)
    {
        $this->editingItem['index'] = $index;
        $this->editingItem['qtyForReduction'] = '';
        $this->editingItem['food_name'] = $this->orderDetails[$index]['food_name'];
        $this->editingItem['qty'] = $this->orderDetails[$index]['qty'];

        $this->remark = $this->orderDetails[$index]['remark'];

        $this->showRemarkInputModal = true;
    }

    public function changeQty($index, $isAddition = true)
    {
        if ($isAddition) {
            $this->orderDetails[$index]['qty']++;
            $this->orderDetails[$index]['amount'] = $this->orderDetails[$index]['price'] * $this->orderDetails[$index]['qty'];
        } else {
            if ($this->orderDetails[$index]['qty'] > 1) {
                $this->orderDetails[$index]['qty']--;
                $this->orderDetails[$index]['amount'] = $this->orderDetails[$index]['price'] * $this->orderDetails[$index]['qty'];
            } else {
                unset($this->orderDetails[$index]);
                $this->orderDetails = array_values($this->orderDetails);
            }
        }
    }

    public function addToOrder(Food $food)
    {
        $itemExist = false;
        for ($i=0; $i < count($this->orderDetails); $i++) {
            if (!isset($this->orderDetails[$i]['id'])) {
                if ($this->orderDetails[$i]['food_id'] == $food->id) {
                    $itemExist = true;

                    $this->orderDetails[$i]['qty']+= 1;
                    $this->orderDetails[$i]['amount'] = $this->orderDetails[$i]['qty'] * $this->orderDetails[$i]['price'];
                }
            }
        }

        if (!$itemExist) {
            array_push($this->orderDetails, [
                'id' => null,
                'order_time' => $this->order_time + 1,
                'food_id' => $food->id,
                'food_name' => $food->food_name,
                'price' => $food->price,
                'qty' => 1,
                'amount' => $food->price,
                'remark' => null
            ]);
        }

        $this->isDirty = true;
    }

    public function updatedSelectedCategoryId()
    {
        $this->foodTypes = FoodType::select('id', 'food_type_name')->withCount('foods')->where('food_category_id', $this->selectedCategoryId)->get();
        if ($this->foodTypes->count() > 0) {
            $this->selectedFoodTypeId = $this->foodTypes->first()->id;
        } else {
            $this->selectedFoodTypeId = null;
        }
    }

    public function createOrder(Table $table)
    {
        $this->reset();

        $this->table_id = $table->id;
        $this->fill($table);

        if (!is_null($table->room)) {
            $this->inhouse_id = $table->room->inhouses()->select('id')->where('checked_out', false)->first()->id;
            $this->room_no = $table->room->room_no;
        };

        $this->categories = FoodCategory::all('id', 'food_category_name');
        $this->selectedCategoryId = $this->categories->first()->id;

        $this->foodTypes = FoodType::select('id', 'food_type_name')->withCount('foods')->where('food_category_id', $this->selectedCategoryId)->get();
        $this->selectedFoodTypeId = $this->foodTypes->first()->id;

        // $this->paymentTypes = PaymentType::all('id', 'payment_type_name');
        // $this->payment_type_id = $this->paymentTypes->first()->id;

        $order = $table->orders()->where('is_paid', false)->first();

        if (isset($order)) {
            $this->fill($order);
            $this->order_id = $order->id;
            // if (isset($order->customer)) {
            //     $customer = $order->customer;
            //     $this->fill($customer);
            //     $this->customerSearch = $this->customer_name;
            // }

            // $orderDetails = $order->orderDetails->sortBy('order_time');
            // if ($orderDetails->count() > 0) {
            //     $this->order_time = $orderDetails->last()->order_time;
            //     foreach ($orderDetails as $orderDetail) {
            //         array_push($this->orderDetails, [
            //             'id' => $orderDetail->id,
            //             'order_time' => $orderDetail->order_time,
            //             'food_id' => $orderDetail->food_id,
            //             'food_name' => $orderDetail->food->food_name,
            //             'qty' => $orderDetail->qty,
            //             'price' => $orderDetail->price,
            //             'amount' => $orderDetail->qty * $orderDetail->price,
            //             'remark' => $orderDetail->remark
            //         ]);
            //     }
            // }
        }


        $this->showHandleTableOrderModal = true;
    }

    public function render()
    {
        return view('livewire.live-modal-handle-fb-table-order', [
            'foods' => Food::with('foodType')
                ->select('id', 'food_image', 'food_type_id', 'food_name', 'price')
                ->when(strlen($this->fnbSearch) >= 2, function ($query) {
                    $query->where('food_name', 'like', '%' . $this->fnbSearch . '%');
                }, function ($query) {
                    $query->where('food_type_id', $this->selectedFoodTypeId);
                })->get(),

            // 'customers' => Customers::where(function ($query) {
            //     $query->when(strlen($this->customerSearch) >= 2 ? $this->customerSearch : false, function ($query) {
            //         $query->where('customer_name', 'like', '%' . $this->customerSearch . '%');
            //     });
            // })->get(),

        ]);
    }
}
