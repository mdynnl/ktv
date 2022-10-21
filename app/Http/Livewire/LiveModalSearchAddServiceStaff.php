<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Livewire\Component;

class LiveModalSearchAddServiceStaff extends Component
{
    public $search = '';
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
        $this->caller = $caller;
        $this->showSearchAddServiceStaff = true;
    }

    public function render()
    {
        return view('livewire.live-modal-search-add-service-staff', [
            'staffs' => ServiceStaff::when(strlen($this->search) >= 2 ? $this->search : false, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })->get(),
        ]);
    }
}
