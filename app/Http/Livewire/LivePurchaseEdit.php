<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\PaymentType;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class LivePurchaseEdit extends Component
{
    // Purchase fills
    public $purchase_id;
    public $purchase_date;
    public $invoice_no;
    public $supplier_id;
    public $due_date;
    public $total;
    public $discount = 0;
    public $tax = 0;
    public $amount;
    public $payment_type_id;
    public $is_paid = true;
    public $updated_user_id;

    // Purchase Detail Fills
    public $purchaseDetails = [];

    public $items = [];
    public $suppliers = [];
    public $paymentTypes = [];

    // States
    public $showPurchaseEditModal = false;
    public $showDeleteConfirmationModal = false;
    public $editPurchaseNow = false;
    public $editingPurchaseDetail = [];
    public $editingPurchaseDetailIndex;
    public $isDirty = false;

    protected $listeners = ['editPurchase', 'purchaseEditAddItems', 'purchaseDetailUpdated', 'purchaseDetailDeleted'];

    protected $rules = [
        'purchase_date' => 'required|date',
        'invoice_no' => 'nullable',
        'supplier_id' => 'required|integer',
        'due_date' => 'nullable|date',
        'total' => 'required|numeric|between:0,999999999.99',
        'discount' => 'nullable|numeric|between:0,999999999.99',
        'tax' => 'nullable|numeric|between:0,999999999.99',
        'amount' => 'required|numeric|between:0,999999999.99',
        'payment_type_id' => 'required|integer',
        'updated_user_id' => 'required|integer'
    ];

    public function update()
    {
        $this->updated_user_id = auth()->id();

        $validated = $this->validate();

        $purchase = Purchase::find($this->purchase_id);

        $purchase->update($validated);

        $this->emit('purchaseUpdated');
        $this->isDirty = false;
        // $this->showPurchaseEditModal = false;
    }

    public function purchaseDetailUpdated($validated)
    {
        $this->purchaseDetails[$this->editingPurchaseDetailIndex] = $validated;
        $this->updateAmountAndTotal();
    }

    public function editPurchaseDetailEdit($index)
    {
        $this->editingPurchaseDetailIndex = $index;
        $this->emit('editPurchaseDetail', $this->purchaseDetails[$index]);
    }

    public function purchaseDetailDeleted()
    {
        unset($this->purchaseDetails[$this->editingPurchaseDetailIndex]);
        $this->purchaseDetails = array_values($this->purchaseDetails);
        $this->updateAmountAndTotal();
    }

    public function removePurchaseDetails($index)
    {
        if ($this->purchaseDetails[$index]['purchase_detail_id']) {
            $this->editingPurchaseDetailIndex = $index;
            $this->emit('deletePurchaseDetail', $this->purchaseDetails[$index]['purchase_detail_id']);
        } else {
            unset($this->purchaseDetails[$index]);
            $this->purchaseDetails = array_values($this->purchaseDetails);
        };
    }

    public function updatedTax()
    {
        $this->temporaryUpdateAmountAndTotal();
    }

    public function updatedDiscount()
    {
        $this->temporaryUpdateAmountAndTotal();
    }

    public function temporaryUpdateAmountAndTotal()
    {
        $this->tax = empty($this->tax) ? 0 : $this->tax;
        $this->discount = empty($this->discount) ? 0 : $this->discount;
        $this->amount = 0;
        $this->total = 0;
        foreach ($this->purchaseDetails	as  $pd) {
            $this->amount+= ($pd['price'] * $pd['qty']);
        }

        $this->total = ($this->amount + $this->tax) - $this->discount;

        $this->isDirty = true;
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

        Purchase::find($this->purchase_id)->update([
            'amount' => $this->amount,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total' => $this->total,
        ]);
        $this->emit('purchaseUpdated');
    }

    public function updated()
    {
        $this->isDirty = true;
    }

    public function purchaseEditAddItems($validated)
    {
        array_push($this->purchaseDetails, [
            'purchase_detail_id' => $validated['item_id'],
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

    public function editPurchase(Purchase $purchase)
    {
        $this->resetValidation();
        $this->reset();

        $this->fill($purchase);
        $this->purchase_id = $purchase->id;

        $purchaseDetails = $purchase->purchaseDetails()->with('item')->get();

        $this->purchaseDetails = [];
        foreach ($purchaseDetails as $pd) {
            array_push($this->purchaseDetails, [
                'purchase_detail_id' => $pd->id,
                'item_id' => $pd->item_id,
                'item_name' => $pd->item->item_name,
                'invoice_unit' => $pd->invoice_unit,
                'recipe_unit' => $pd->item->recipe_unit,
                'price' => $pd->price,
                'qty' => $pd->qty,
                'recipe_qty' => $pd->recipe_qty,
            ]);
        }

        $this->editPurchaseNow = true;

        $this->showPurchaseEditModal = true;
    }

    public function render()
    {
        if ($this->editPurchaseNow) {
            $this->items = Item::all('id', 'item_name');
            $this->suppliers = Supplier::all('id', 'supplier_name');
            $this->paymentTypes = PaymentType::all('id', 'payment_type_name');
        }
        return view('livewire.live-purchase-edit');
    }
}
