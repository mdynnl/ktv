<?php

namespace App\Http\Livewire;

use App\Models\StockOut;
use App\Models\StockOutType;
use Livewire\Component;

class LiveStockOutIndex extends Component
{
    public $toDate;
    public $fromDate;
    public $stockOutTypes;
    public $selectedStockOutTypeId;

    protected $listeners = [
        'stockoutCreated' => '$refresh',
        'stockoutUpdated' => '$refresh',
        'stockoutDeleted' => '$refresh',
    ];

    public function mount()
    {
        $this->stockOutTypes = StockOutType::all('id', 'stock_out_type_name');
        $this->toDate = today()->toDateString();
        $this->fromDate = today()->subWeek()->toDateString();
    }

    public function render()
    {
        return view('livewire.live-stock-out-index', [
            'stockouts' => StockOut::with(['item', 'stockOutType'])
            ->when($this->selectedStockOutTypeId, function ($query) {
                $query->where('stock_out_type_id', $this->selectedStockOutTypeId);
            })
            ->whereDate('stock_out_date', '>=', $this->fromDate)
            ->whereDate('stock_out_date', '<=', $this->toDate)
            ->get()
        ]);
    }
}
