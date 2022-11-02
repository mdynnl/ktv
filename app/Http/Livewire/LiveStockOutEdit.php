<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\StockOut;
use App\Models\StockOutType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveStockOutEdit extends Component
{
    use AuthorizesRequests;

    public $stockout_id;
    public $stock_out_date;
    public $item_id;
    public $qty;
    public $stock_out_type_id;
    public $remark;
    public $updated_user_id;

    public $original_stock_out_qty;

    public $stockOutTypes = [];
    public $items = [];

    public $showStockoutEditForm = false;

    protected $listeners = ['editStockout'];

    protected $rules = [
        'stock_out_date' => 'required|date',
        'item_id' => 'required|integer',
        'qty' => 'required|numeric',
        'stock_out_type_id' => 'required|integer',
        'remark' => 'nullable|string',
        'updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $validated = $this->validate();
        DB::transaction(function () use ($validated) {
            $stockout = StockOut::find($this->stockout_id);

            $stockout->update($validated);

            if ($validated['qty'] > $this->original_stock_out_qty) {
                $decrementingQty = $validated['qty'] - $this->original_stock_out_qty;
                Item::find($validated['item_id'])->decrement('current_qty', $decrementingQty);
            } elseif ($validated['qty'] < $this->original_stock_out_qty) {
                $incrementingQty = $this->original_stock_out_qty - $validated['qty'];
                Item::find($validated['item_id'])->increment('current_qty', $incrementingQty);
            }

            $this->emit('stockoutUpdated');
            $this->showStockoutEditForm = false;
        });
    }

    public function editStockout(StockOut $stockOut)
    {
        $this->authorize('edit stockout');

        $this->resetValidation();
        $this->reset();

        $this->fill($stockOut);
        $this->stockout_id = $stockOut->id;
        $this->original_stock_out_qty = $this->qty;
        $this->updated_user_id = auth()->id();

        $this->stockOutTypes = StockOutType::all('id', 'stock_out_type_name');
        $this->items = Item::select('id', 'item_name')->orderBy('item_name')->get();

        $this->showStockoutEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-stock-out-edit');
    }
}
