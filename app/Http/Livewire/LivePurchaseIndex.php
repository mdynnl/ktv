<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class LivePurchaseIndex extends Component
{
    public $fromDate;
    public $toDate;
    public $selectedSupplierId;
    public $search = '';

    protected $listeners = [
        'purchaseCreated' => '$refresh',
        'purchaseUpdated' => '$refresh',
        'purchaseDeleted' => '$refresh',
    ];

    public function mount()
    {
        $this->toDate = today()->toDateString();
        $this->fromDate = today()->subWeek()->toDateString();
    }

    public function render()
    {
        return view('livewire.live-purchase-index', [
            'suppliers' => Supplier::all('id', 'supplier_name'),
            'purchases' => Purchase::with('supplier')->when(strlen($this->search) > 1 ? $this->search : false, function ($query) {
                $query->where('invoice_no', $this->search);
            })
            ->when($this->selectedSupplierId ?? false, function ($query) {
                $query->where('supplier_id', $this->selectedSupplierId);
            })
            ->whereDate('purchase_date', '>=', $this->fromDate)
            ->whereDate('purchase_date', '<=', $this->toDate)
            ->get()
        ]);
    }
}
