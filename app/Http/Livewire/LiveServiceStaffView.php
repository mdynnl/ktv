<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Livewire\Component;

class LiveServiceStaffView extends Component
{
    public $search = '';

    protected $listeners = ['serviceStaffDeleted' => '$refresh'];

    public function render()
    {
        return view('livewire.live-service-staff-view', [
            'staffs' => ServiceStaff::when(strlen($this->search) >= 2 ? $this->search : false, function ($query) {
                $query->where('name_on_nrc', 'like', '%' . $this->search . '%')
                ->orWhere('nick_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get()

        ]);
    }
}
