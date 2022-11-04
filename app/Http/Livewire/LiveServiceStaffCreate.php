<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveServiceStaffCreate extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $profile_image;
    public $full_size_image;
    public $name_on_nrc;
    public $nick_name;
    public $nrc;
    public $dob;
    public $address;
    public $phone;
    public $isActive;

    public $showServiceStaffCreateForm = false;

    protected $listeners = ['createServiceStaff'];

    protected $rules = [
        'profile_image' => 'nullable|image|max:512',
        'full_size_image' => 'nullable|image|max:1024',
        'name_on_nrc' => 'required|string',
        'nick_name' => 'required|string',
        'nrc' => 'nullable|string|unique:service_staff,nrc',
        'dob' => 'nullable|date',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'isActive' => 'required|boolean',
    ];

    public function create()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            if ($this->profile_image) {
                $imagePath = $this->profile_image->store('service-staff-images');
                $validated['profile_image'] = $imagePath;
            }

            if ($this->full_size_image) {
                $imagePath = $this->full_size_image->store('service-staff-images');
                $validated['full_size_image'] = $imagePath;
            }

            $user = ServiceStaff::create($validated);
        });


        $this->emit('serviceStaffCreated');
        $this->showServiceStaffCreateForm = false;
    }


    public function createServiceStaff()
    {
        $this->authorize('create', ServiceStaff::class);
        $this->resetValidation();
        $this->reset();

        $this->isActive = true;
        $this->showServiceStaffCreateForm = true;
    }

    // public function render()
    // {
    //     return view('livewire.live-service-staff-create');
    // }
}
