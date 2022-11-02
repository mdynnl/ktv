<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class LiveViewPurchaseInvoice extends Component
{
    public $purchase;
    public $purchaseDetails;
    public $showPurchaseInvoiceModal = false;

    protected $listeners = ['showPurchaseInvoice'];

    public function showPurchaseInvoice(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->showPurchaseInvoiceModal = true;
    }

    public function render()
    {
        if ($this->purchase) {
            $this->purchaseDetails = $this->purchase->purchaseDetails->load('item');
        }
        return view('livewire.live-view-purchase-invoice');
    }
}
