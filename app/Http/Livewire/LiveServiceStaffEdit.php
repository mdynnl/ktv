<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveServiceStaffEdit extends Component
{
    use WithFileUploads;

    public $serviceStaff;
    public $service_staff_id;
    public $profile_image;
    public $full_size_image;
    public $name_on_nrc;
    public $nick_name;
    public $nrc;
    public $address;
    public $phone;
    public $isActive;

    public $new_profile_image;
    public $new_full_size_image;

    protected function rules()
    {
        return [
            'new_profile_image' => 'nullable|image|max:512',
            'new_full_size_image' => 'nullable|image|max:1024',
            'name_on_nrc' => 'required|string',
            'nick_name' => 'nullable|string',
            'nrc' => 'nullable|string|unique:service_staff,nrc,'.$this->service_staff_id,
            'address' => 'nullable|string',
            'phone' => 'required|string',
            'isActive' => 'required|boolean',
        ];
    }

    public function updateUser()
    {
        $validated = $this->validate();


        DB::transaction(function () use ($validated) {
            $validatedWithImageUpdates = $this->checkAndUpdateImage($validated);
            $this->serviceStaff->update([
                'profile_image' => isset($validatedWithImageUpdates['new_profile_image']) ? $validatedWithImageUpdates['new_profile_image'] : $this->profile_image,
                'full_size_image' => isset($validatedWithImageUpdates['new_full_size_image']) ? $validatedWithImageUpdates['new_full_size_image'] : $this->full_size_image,
                'name_on_nrc' => $validated['name_on_nrc'],
                'nick_name' => $validated['nick_name'],
                'nrc' => $validated['nrc'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'isActive' => $validated['isActive'],
            ]);
        });

        return redirect()->route('service-staff.index');
    }

    public function mount(ServiceStaff $serviceStaff)
    {
        $this->serviceStaff = $serviceStaff;
        $this->service_staff_id = $serviceStaff->id;
        $this->fill($serviceStaff);
    }

    public function render()
    {
        return view('livewire.live-service-staff-edit');
    }

    protected function checkAndUpdateImage($validated)
    {
        if ($this->new_profile_image) {
            if ($this->profile_image) {
                Storage::delete($this->profile_image);
            }
            $validated['new_profile_image'] = $this->new_profile_image->store('service-staff-images');
        }

        if ($this->new_full_size_image) {
            if ($this->full_size_image) {
                Storage::delete($this->full_size_image);
            }
            $validated['new_full_size_image'] = $this->new_full_size_image->store('service-staff-images');
        }

        return $validated;
    }
}
