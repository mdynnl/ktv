<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaffRate;
use Livewire\Component;

class LiveServiceStaffRateEdit extends Component
{
    public $serviceStaffRate;
    public $showServiceStaffRateEditForm = false;

    protected $listeners = ['editStaffRate'];

    protected $rules = [
        'serviceStaffRate.service_staff_rate' => 'required|numeric|between:0,999999999.99',
        'serviceStaffRate.service_staff_commission_rate' => 'required|numeric|between:0,999999999.99',
        'serviceStaffRate.updated_user_id' => 'required|integer'
    ];

    public function update()
    {
        $this->serviceStaffRate->updated_user_id = auth()->id();

        $this->validate();

        $this->serviceStaffRate->update();

        $this->emit('staffRateUpdated');

        $this->showServiceStaffRateEditForm = false;
    }

    public function editStaffRate()
    {
        $this->resetValidation();
        $this->reset();

        $this->serviceStaffRate = ServiceStaffRate::first();
        $this->showServiceStaffRateEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-service-staff-rate-edit');
    }
}
