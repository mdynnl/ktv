<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use App\Traits\WithPrinting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveServiceStaffCommissionSummaryReport extends Component
{
    use AuthorizesRequests;
    use WithPrinting;

    public $serviceStaffs;
    public $commissionSummaries;
    public $selectedStaffId = '';
    public $viewOnlyActive = false;
    public $dateFrom;
    public $dateTo;

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['filter'] = $this->viewOnlyActive ? 'Active Only' : 'All View';
        $data['commissionSummaries'] = $this->commissionSummaries;
        return $this->printToPDF('pdf.commission-summary-pdf', $data, today()->toDateString(), "Commission-Summary", 'L');
    }

    public function hydrate()
    {
        $this->commissionSummaries = $this->getCommissionSummery();
    }

    public function mount()
    {
        $this->authorize('view reports');
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
        $this->serviceStaffs = ServiceStaff::select('id', 'nick_name')->orderBy('nick_name')->get();
    }

    public function render()
    {
        $this->commissionSummaries = $this->getCommissionSummery();
        return view('livewire.live-service-staff-commission-summary-report');
    }

    protected function getCommissionSummery()
    {
        return DB::select(
            "SELECT
				service_staff_id,
				profile_image,
				nick_name,
				session_hours, service_staff_rate, service_staff_commission_rate, session_hours * service_staff_commission_rate commission_amount
				from
				(
					select service_staff_id, sum(session_hours) session_hours, service_staff_rate, service_staff_commission_rate
					from inhouse_services
					where convert(operation_date, date) >= '$this->dateFrom'
					and convert(operation_date, date) <= '$this->dateTo'
					group by
						service_staff_id,
						service_staff_rate,
						service_staff_commission_rate
				) i
				left join service_staff s on i.service_staff_id = s.id
			"
            . (!empty($this->selectedStaffId) ? "where service_staff_id = '$this->selectedStaffId '" : " ")
            . ($this->viewOnlyActive
                ? (!empty($this->selectedStaffId) ? "and isActive = $this->viewOnlyActive" : "where isActive = $this->viewOnlyActive")
                : " ")
        );
    }
}
