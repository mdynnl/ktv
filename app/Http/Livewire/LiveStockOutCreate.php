<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\StockOut;
use App\Models\StockOutType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveStockOutCreate extends Component
{
    use AuthorizesRequests;

    public $stock_out_date;
    public $item_id;
    public $qty;
    public $stock_out_type_id;
    public $remark;
    public $created_user_id;

    public $stockOutTypes = [];
    public $items = [];

    public $showStockoutCreateForm = false;

    protected $listeners = ['createStockout'];

    protected $rules = [
        'stock_out_date' => 'required|date',
        'item_id' => 'required|integer',
        'qty' => 'required|numeric',
        'stock_out_type_id' => 'required|integer',
        'remark' => 'nullable|string',
        'created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            StockOut::create($validated);
            Item::find($validated['item_id'])->decrement('current_qty', $validated['qty']);

            $this->emit('stockoutCreated');
            $this->showStockoutCreateForm = false;
        });
    }

    public function createStockout()
    {
        $this->authorize('add stockout');

        $this->resetValidation();
        $this->reset();

        $this->stockOutTypes = StockOutType::all('id', 'stock_out_type_name');
        $this->items = Item::select('id', 'item_name')->orderBy('item_name')->get();
        $this->stock_out_date = today()->toDateString();
        $this->created_user_id = auth()->id();
        $this->showStockoutCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-stock-out-create');
    }
}
