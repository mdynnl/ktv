<?php

namespace App\Http\Livewire;

use App\Models\ServiceStaff;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class LiveServiceStaffDelete extends Component
{
    use AuthorizesRequests;
    public $serviceStaff;
    public $showServiceStaffDeleteModal = false;

    protected $listeners = ['deleteServiceStaff'];

    public function delete()
    {
        try {
            DB::transaction(function () {
                if (isset($this->serviceStaff->profile_image)) {
                    Storage::delete($this->serviceStaff->profile_image);
                }

                if (isset($this->serviceStaff->full_size_image)) {
                    Storage::delete($this->serviceStaff->full_size_image);
                }

                $this->serviceStaff->delete();
            });
            $this->emit('serviceStaffDeleted');
            $this->showServiceStaffDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showServiceStaffDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Service Staff Delete Unsuccessful", 'body' => "Cannot delete {$this->serviceStaff->name_on_nrc} ({$this->serviceStaff->nick_name}) cause other related data exist. Please delete related data first to delete this service staff."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteServiceStaff(ServiceStaff $serviceStaff)
    {
        $this->authorize('delete', $serviceStaff);
        $this->serviceStaff = $serviceStaff;
        $this->showServiceStaffDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-service-staff-delete');
    }
}
