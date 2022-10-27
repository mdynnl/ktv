<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\PaymentType;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LivePurchaseCreate extends Component
{
    // Purchase fills
    public $purchase_date;
    public $invoice_no;
    public $supplier_id;
    public $due_date;
    public $total = 0;
    public $discount = 0;
    public $tax = 0;
    public $amount = 0;
    public $payment_type_id;
    public $is_paid = true;
    public $created_user_id;

    // Purchase Detail Fills
    public $purchaseDetails = [];

    public $items = [];
    public $suppliers = [];
    public $paymentTypes = [];

    // States
    public $showPurchaseCreateModal = false;
    public $showDeleteConfirmationModal = false;
    public $createPurchaseNow = false;
    public $editingPurchaseDetail = [];
    public $editingPurchaseDetailIndex;

    protected $listeners = ['createPurchase', 'purchaseCreateAddItems', 'createPurchaseDetailUpdated'];

    protected $rules = [
        'purchase_date' => 'required|date',
        'invoice_no' => 'nullable|string',
        'supplier_id' => 'required|integer',
        'due_date' => 'nullable|date',
        'total' => 'required|numeric|between:0,999999999.99',
        'discount' => 'nullable|numeric|between:0,999999999.99',
        'tax' => 'nullable|numeric|between:0,999999999.99',
        'amount' => 'required|numeric|between:0,999999999.99',
        'payment_type_id' => 'required|integer',
        'created_user_id' => 'required|integer'
    ];

    public function create()
    {
        $this->created_user_id = auth()->id();

        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $purchase = Purchase::create($validated);

            foreach ($this->purchaseDetails as $detail) {
                $purchase->purchaseDetails()->create([
                    'item_id' => $detail['item_id'],
                    'invoice_unit' => $detail['invoice_unit'],
                    'price' => $detail['price'],
                    'qty' => $detail['qty'],
                    'recipe_qty' => $detail['recipe_qty'],
                ]);

                Item::find($detail['item_id'])->increment('current_qty', $detail['recipe_qty']);
            }

            $this->emit('purchaseCreated');
        });

        $this->showPurchaseCreateModal = false;
    }

    public function createPurchaseDetailUpdated($validated)
    {
        $this->purchaseDetails[$this->editingPurchaseDetailIndex] = $validated;
        $this->updateAmountAndTotal();
    }

    public function editPurchaseDetailEdit($index)
    {
        $this->editingPurchaseDetailIndex = $index;
        $this->emit('editPurchaseDetail', $this->purchaseDetails[$index]);
    }

    public function askForConfirmationBeforeDelete()
    {
        $this->showDeleteConfirmationModal = true;
    }

    public function removePurchaseDetails($index)
    {
        if ($this->purchaseDetails[$index]['purchase_detail_id']) {
            $this->askForConfirmationBeforeDelete();
        } else {
            unset($this->purchaseDetails[$index]);
            $this->purchaseDetails = array_values($this->purchaseDetails);
            $this->updateAmountAndTotal();
        };
    }

    public function purchaseCreateAddItems($validated)
    {
        array_push($this->purchaseDetails, [
            'purchase_detail_id' => null,
            'item_id' => $validated['item_id'],
            'item_name' => Item::select('item_name')->find($validated['item_id'])->item_name,
            'invoice_unit' => $validated['invoice_unit'],
            'recipe_unit' => $validated['recipe_unit'],
            'price' => $validated['price'],
            'qty' => $validated['qty'],
            'recipe_qty' => $validated['recipe_qty'],
        ]);

        $this->updateAmountAndTotal();
    }

    public function updatedTax()
    {
        $this->updateAmountAndTotal();
    }

    public function updatedDiscount()
    {
        $this->updateAmountAndTotal();
    }

    public function updateAmountAndTotal()
    {
        $this->tax = empty($this->tax) ? 0 : $this->tax;
        $this->discount = empty($this->discount) ? 0 : $this->discount;

        $this->amount = 0;
        $this->total = 0;
        foreach ($this->purchaseDetails	as  $pd) {
            $this->amount+= ($pd['price'] * $pd['qty']);
        }

        $this->total = ($this->amount + $this->tax) - $this->discount;
    }

    public function createPurchase()
    {
        $this->resetValidation();
        $this->reset();

        $this->purchase_date = today()->toDateString();

        $this->createPurchaseNow = true;
        $this->showPurchaseCreateModal = true;
    }

    public function render()
    {
        if ($this->createPurchaseNow) {
            $this->items = Item::all('id', 'item_name');
            $this->suppliers = Supplier::all('id', 'supplier_name');
            $this->paymentTypes = PaymentType::all('id', 'payment_type_name');
        }

        return view('livewire.live-purchase-create');
    }
}
