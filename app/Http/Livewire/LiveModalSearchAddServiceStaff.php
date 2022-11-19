<?php

namespace App\Http\Livewire;

use App\Models\InhouseService;
use App\Models\ServiceStaff;
use Livewire\Component;

class LiveModalSearchAddServiceStaff extends Component
{
    public $search = '';
    public $staffs = [];
    public $showSearchAddServiceStaff = false;
    public $selectedStaff = [];
    public $caller;

    protected $listeners = ['searchAddStaff'];

    public function addToCallersList()
    {
        if ($this->caller == 'checkIn') {
            $this->emit('checkInAddServiceStaffs', $this->selectedStaff);
        } elseif ($this->caller == 'inhouseEdit') {
            $this->emit('inhouseEditAddServiceStaffs', $this->selectedStaff);
        } else {
            $this->emit('walkInAddWalkInGuest', $this->selectedStaff);
        }
        $this->closeSearchAddStaffModal();
    }

    public function closeSearchAddStaffModal()
    {
        $this->showSearchAddServiceStaff = false;
        $this->reset();
    }

    public function searchAddStaff($caller)
    {
        $this->reset();
        $this->caller = $caller;
        $this->showSearchAddServiceStaff = true;
    }

    public function render()
    {
        if ($this->showSearchAddServiceStaff) {
            $inSessionStaffs = InhouseService::select('service_staff_id')->where('is_checked_out', false)->get()->pluck('service_staff_id');

            $this->staffs = ServiceStaff::when(strlen($this->search) >= 2 ? $this->search : false, function ($query, $search) {
                $query->where('nick_name', 'like', '%'.$search.'%');
                // ->orWhere('nick_name', 'like', '%'.$search.'%');
            })
            ->where('isActive', true)
            ->whereNotIn('id', $inSessionStaffs)
            ->orderBy('nick_name')->get();
        }
        return view('livewire.live-modal-search-add-service-staff');
    }
}
