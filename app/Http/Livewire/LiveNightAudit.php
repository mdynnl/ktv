<?php

namespace App\Http\Livewire;

use App\Models\CurrentOperationDate;
use App\Models\HousekeepingStatus;
use App\Models\IncomeFO;
use App\Models\Inhouse;
use App\Models\LogNightAudit;
use App\Models\ManagerReport;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LiveNightAudit extends Component
{
    public $operationDate;
    public $showNightAuditConfirmModal = false;

    protected $listeners = ['runNightAudit'];

    public function runNightAudit()
    {
        $this->operationDate = CurrentOperationDate::first('operation_date')->operation_date;

        if (CurrentOperationDate::whereDate('operation_date', today()->toDateString())->exists()) {
            return $this->dispatchBrowserEvent('failure-notify', ['title' => "Audit Unsuccessful", 'body' => "The operation date is at its latest."]);
        }

        $this->showNightAuditConfirmModal = true;
    }

    public function run()
    {
        $this->showNightAuditConfirmModal = false;
        $newDate = Carbon::parse($this->operationDate)->addDay()->format('Y-m-d');
        CurrentOperationDate::first()->update([
            'operation_date' => $newDate
        ]);

        $this->dispatchBrowserEvent('success-notify', ['title' => "Audit Successful", 'body' => "Operation Date updated successfully."]);
    }
}
