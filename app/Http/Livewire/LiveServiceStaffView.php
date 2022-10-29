<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Livewire\Component;

class LiveServiceStaffView extends Component
{
    public $search = '';

    protected $listeners = [
        'serviceStaffDeleted' => '$refresh',
        'serviceStaffUpdated' => '$refresh',
        'serviceStaffCreated' => '$refresh',
        'staffRateUpdated' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.live-service-staff-view', [
            'serviceStaffRate' => app('ServiceStaffRates')->service_staff_rate,
            'serviceStaffCommissionRate' => app('ServiceStaffRates')->service_staff_commission_rate,
            'staffs' => ServiceStaff::when(strlen($this->search) >= 2 ? $this->search : false, function ($query) {
                $query->where('name_on_nrc', 'like', '%' . $this->search . '%')
                ->orWhere('nick_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name_on_nrc')
            ->get()

        ]);
    }
}
