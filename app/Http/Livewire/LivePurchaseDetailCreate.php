<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Livewire\Component;

class LivePurchaseDetailCreate extends Component
{
    public $purchase_id;

    public $item_id;
    public $item_name;
    public $invoice_unit;
    public $price;
    public $qty;
    public $recipe_qty;
    public $recipe_unit;

    public $showSearchAddItem = false;

    protected $listeners = ['searchAddItem'];


    public function addToCallersList()
    {
        $validated = $this->validate([
            'purchase_id' => 'nullable|integer',
            'item_id' => 'required|integer',
            'item_name' => 'required|string',
            'invoice_unit' => 'required|string',
            'recipe_unit' => 'required|string',
            'price' => 'required|numeric|between:0,999999999.99',
            'qty' => 'required|integer',
            'recipe_qty' => 'required|integer'
        ]);

        if ($this->purchase_id) {
            $pd = PurchaseDetail::create([
                'purchase_id' => $validated['purchase_id'],
                'item_id' => $validated['item_id'],
                'invoice_unit' => $validated['invoice_unit'],
                'price' => $validated['price'],
                'qty' => $validated['qty'],
                'recipe_qty' => $validated['recipe_qty']
            ]);

            Item::find($validated['item_id'])->increment('current_qty', $validated['recipe_qty']);

            $validated['purchase_detail_idj'] = $pd->id;

            $this->emit('purchaseEditAddItems', $validated);
        } else {
            $this->emit('purchaseCreateAddItems', $validated);
        }

        $this->showSearchAddItem = false;
    }

    public function updatedItemId()
    {
        $item = Item::find($this->item_id);
        $this->item_name = $item->item_name;
        $this->recipe_unit = $item->recipe_unit;
    }

    public function searchAddItem($purchase_id = null)
    {
        $this->resetValidation();
        $this->reset();

        $this->purchase_id = $purchase_id;

        $this->showSearchAddItem = true;
    }
    public function render()
    {
        return view('livewire.live-purchase-detail-create', [
            'items' => Item::all('id', 'item_name'),
        ]);
    }
}
