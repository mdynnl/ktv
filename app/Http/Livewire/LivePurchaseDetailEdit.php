<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\PurchaseDetail;
use Livewire\Component;

class LivePurchaseDetailEdit extends Component
{
    public $purchase_detail_id;
    public $item_id;
    public $item_name;
    public $invoice_unit;
    public $price;
    public $qty;
    public $recipe_qty;
    public $original_recipe_qty;
    public $recipe_unit;

    public $showPurchaseDetailEditForm = false;

    protected $listeners = ['editPurchaseDetail'];

    public function updateCallerList()
    {
        $validated = $this->validate([
            'purchase_detail_id' => 'nullable|integer',
            'item_id' => 'required|integer',
            'item_name' => 'required|string',
            'invoice_unit' => 'required|string',
            'recipe_unit' => 'required|string',
            'price' => 'required|numeric|between:0,999999999.99',
            'qty' => 'required|integer',
            'recipe_qty' => 'required|integer'
        ]);

        if ($this->purchase_detail_id) {
            $pd = PurchaseDetail::find($this->purchase_detail_id);
            $pd->update([
                'item_id' => $validated['item_id'],
                'invoice_unit' => $validated['invoice_unit'],
                'price' => $validated['price'],
                'qty' => $validated['qty'],
                'recipe_qty' => $validated['recipe_qty']
            ]);

            if ($validated['recipe_qty'] > $this->original_recipe_qty) {
                $incrementingQty = $validated['recipe_qty'] - $this->original_recipe_qty;
                Item::find($validated['item_id'])->increment('current_qty', $incrementingQty);
            } elseif ($validated['recipe_qty'] < $this->original_recipe_qty) {
                $decrementingQty = $this->original_recipe_qty - $validated['recipe_qty'];
                Item::find($validated['item_id'])->decrement('current_qty', $decrementingQty);
            }

            $this->emit('purchaseDetailUpdated', $validated);
        } else {
            $this->emit('createPurchaseDetailUpdated', $validated);
        }
        $this->showPurchaseDetailEditForm = false;
    }

    public function updatedItemId()
    {
        $item = Item::find($this->item_id);
        $this->item_name = $item->item_name;
        $this->recipe_unit = $item->recipe_unit;
    }

    public function editPurchaseDetail($data)
    {
        $this->fill($data);

        if ($data['purchase_detail_id']) {
            $this->purchase_detail_id = $data['purchase_detail_id'];
            $this->original_recipe_qty = $data['recipe_qty'];
        }

        $this->showPurchaseDetailEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-purchase-detail-edit', [
            'items' => Item::all('id', 'item_name'),
        ]);
    }
}
