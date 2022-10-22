<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveServiceStaffCreate extends Component
{
    use WithFileUploads;

    public $profile_image;
    public $full_size_image;
    public $name_on_nrc;
    public $nick_name;
    public $nrc;
    public $address;
    public $phone;
    public $isActive;

    protected $rules = [
        'profile_image' => 'nullable|image|max:512',
        'full_size_image' => 'nullable|image|max:1024',
        'name_on_nrc' => 'required|string',
        'nick_name' => 'nullable|string',
        'nrc' => 'nullable|string|unique:service_staff,nrc',
        'address' => 'nullable|string',
        'phone' => 'required|string',
        'isActive' => 'required|boolean',
    ];

    public function createUser()
    {
        $validated = $this->validate();
        // $validated['password'] = bcrypt($validated['password']);

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


        return redirect()->route('service-staff.index');
    }

    public function mount()
    {
        $this->isActive = false;
    }

    public function render()
    {
        return view('livewire.live-service-staff-create');
    }
}