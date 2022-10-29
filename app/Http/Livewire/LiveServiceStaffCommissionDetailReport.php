<?php

namespace App\Http\Livewire;

use App\Models\InhouseService;
use App\Traits\WithPrinting;
use Livewire\Component;

class LiveServiceStaffCommissionDetailReport extends Component
{
    use WithPrinting;

    public $inhouseServices;
    public $commission;
    public $dateFrom;
    public $dateTo;

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['inhouseServices'] = $this->inhouseServices;
        $data['commission'] = $this->commission;
        return $this->printToPDF('pdf.commission-detail-pdf', $data, app('OperationDate'), "Commission-Detail", 'L');
    }

    public function mount()
    {
        $this->commission = app('ServiceStaffRates')->service_staff_commission_rate;
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
    }

    public function render()
    {
        $this->inhouseServices = InhouseService::with('inhouse.room', 'serviceStaff')
        ->whereDate('operation_date', '>=', $this->dateFrom)
        ->whereDate('operation_date', '<=', $this->dateTo)
        ->get();
        return view('livewire.live-service-staff-commission-detail-report');
    }
}
