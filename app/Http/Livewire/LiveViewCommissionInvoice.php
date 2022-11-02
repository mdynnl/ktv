<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Livewire\Component;

class LiveViewCommissionInvoice extends Component
{
    public $serviceStaff;
    public $inhouseServices;

    public $showCommissionInvoiceModal = false;

    protected $listeners = ['showCommissionInvoice'];

    public function showCommissionInvoice(ServiceStaff $serviceStaff)
    {
        $this->serviceStaff = $serviceStaff;
        $this->showCommissionInvoiceModal = true;
    }

    public function render()
    {
        if ($this->serviceStaff) {
            $this->inhouseServices = $this->serviceStaff->inhouseServices;
        }
        return view('livewire.live-view-commission-invoice');
    }
}
