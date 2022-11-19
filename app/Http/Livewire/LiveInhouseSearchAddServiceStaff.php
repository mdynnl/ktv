<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use App\Models\InhouseService;
use App\Models\ServiceStaff;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LiveInhouseSearchAddServiceStaff extends Component
{
    public $search = '';
    public $staffs = [];
    public $showInhouseSearchAddServiceStaff = false;
    public $selectedStaff = [];
    public $caller;

    public $sessionsPassed;
    public $remainingSessions;

    public $inhouseId;
    public $session_hours;
    public $arrival;
    public $arrivalDate;
    public $arrivalTime;
    public $departure;
    public $departureDate;
    public $departureTime;

    protected $listeners = ['inhouseAddStaff'];

    public function addServiceStaffs()
    {
        foreach ($this->selectedStaff as $staffId) {
            InhouseService::create([
                'inhouse_id' => $this->inhouseId,
                'service_staff_id' => $staffId,
                'checkin_time' => $this->arrivalDate . ' ' . $this->arrivalTime,
                'checkout_time' => $this->departure,
                'session_hours' => $this->session_hours,
                'service_staff_rate' => app('ServiceStaffRates')->service_staff_rate,
                'service_staff_commission_rate' => app('ServiceStaffRates')->service_staff_commission_rate,
                'operation_date' => app('OperationDate')
            ]);
        }

        $this->emit('inhouseServiceStaffAdded');
        $this->showInhouseSearchAddServiceStaff = false;
    }

    public function changeSessionHours($isAddition = true)
    {
        if ($isAddition) {
            $this->remainingSessions += .5;
            $this->session_hours += .5;
            // $this->departure = Carbon::parse($this->departure)->addMinutes(60 * 0.5);
            $this->departure = Carbon::parse($this->departure)->addMinutes(60 * 0.5);
            $this->departureDate = $this->departure->format('Y-m-d');
            $this->departureTime =  $this->departure->format('g:i A');
        } else {
            if ($this->sessionsPassed >= 1 && $this->remainingSessions > .5) {
                $this->remainingSessions -= .5;
                $this->session_hours -= .5;
                $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5);
                $this->departureDate = $this->departure->format('Y-m-d');
                $this->departureTime =  Carbon::parse($this->departure)->format('g:i A');
            } elseif ($this->remainingSessions > 1) {
                $this->remainingSessions -= .5;
                $this->session_hours -= .5;
                $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5);
                $this->departureDate = $this->departure->format('Y-m-d');
                $this->departureTime =  Carbon::parse($this->departure)->format('g:i A');
            }
        }
    }

    public function updatedArrivalDate()
    {
        if ($this->checkDateIsValid()) {
            $this->updateDepartureDateTime();
        };
    }

    public function updatedArrivalTime()
    {
        if ($this->checkDateIsValid()) {
            $this->updateDepartureDateTime();
        };
    }

    public function closeSearchAddStaffModal()
    {
        $this->showInhouseSearchAddServiceStaff = false;
        $this->reset();
    }

    public function inhouseAddStaff(Inhouse $inhouse)
    {
        $this->reset();
        $this->inhouseId = $inhouse->id;
        $this->session_hours = $inhouse->session_hours;
        $this->arrival = $inhouse->arrival;
        $this->departure = $inhouse->departure;

        $this->sessionsPassed = round(now()->diffInMinutes($inhouse->arrival) / 60, 1);
        $this->remainingSessions = $inhouse->session_hours - $this->sessionsPassed;

        $this->arrivalDate = Carbon::parse($this->arrival)->format('Y-m-d');
        $this->arrivalTime = Carbon::parse($this->arrival)->format('H:i');

        $this->departureDate = Carbon::parse($this->departure)->format('Y-m-d');
        $this->departureTime = Carbon::parse($this->departure)->format('g:i A');

        $this->showInhouseSearchAddServiceStaff = true;
    }

    public function render()
    {
        if ($this->showInhouseSearchAddServiceStaff) {
            $inSessionStaffs = InhouseService::select('service_staff_id')->where('is_checked_out', false)->get()->pluck('service_staff_id');

            $this->staffs = ServiceStaff::when(strlen($this->search) >= 2 ? $this->search : false, function ($query, $search) {
                $query->where('nick_name', 'like', '%'.$search.'%');
                // ->orWhere('nick_name', 'like', '%'.$search.'%');
            })
            ->where('isActive', true)
            ->whereNotIn('id', $inSessionStaffs)
            ->orderBy('nick_name')->get();
        }

        return view('livewire.live-inhouse-search-add-service-staff');
    }

    protected function updateDepartureDateTime()
    {
        $sessionInMinutes = $this->session_hours * 60;
        $this->arrival = Carbon::parse($this->arrivalDate . ' ' . $this->arrivalTime);
        $this->departure = $this->arrival->addMinutes($sessionInMinutes);
        $this->departureDate = $this->departure->format('Y-m-d');
        $this->departureTime = $this->departure->format('g:i A');
    }

    protected function checkDateIsValid()
    {
        $isValid = false;
        $arrival = Carbon::parse($this->arrivalDate . ' ' . $this->arrivalTime);

        if ($arrival > $this->departure) {
            $isValid = false;
            $this->dispatchBrowserEvent('unsuccess-inhouse-service-message', ['message' => "Selected Date/Time invalid!"]);
        } else {
            $isValid = true;
            $this->dispatchBrowserEvent('success-inhouse-service-message', ['message' => ""]);
        };

        return $isValid;
    }
}
