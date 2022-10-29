<?php

namespace App\Http\Livewire;

use App\Models\PurchaseDetail;
use App\Traits\WithPrinting;
use Livewire\Component;

class LivePurchaseDetailReport extends Component
{
    use WithPrinting;

    public $purchaseDetails;
    public $dateFrom;
    public $dateTo;
    public $viewOnlyKitchenItem = false;

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['filter'] = $this->viewOnlyKitchenItem ? 'Kitchen Items' : 'All Items';
        $data['purchaseDetails'] = $this->purchaseDetails;
        return $this->printToPDF('pdf.purchase-detail-pdf', $data, app('OperationDate'), "Purchase-Detail", 'L');
    }

    public function mount()
    {
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
    }

    public function render()
    {
        $this->purchaseDetails = PurchaseDetail::with('item', 'purchase')
        ->whereHas('item', function ($query) {
            $query->where('is_kitchen_item', $this->viewOnlyKitchenItem);
        })
        ->whereHas('purchase', function ($query) {
            $query->whereDate('created_at', '>=', $this->dateFrom)
            ->whereDate('created_at', '<=', $this->dateTo);
        })
       ->get();

        return view('livewire.live-purchase-detail-report');
    }
}
