<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Inhouse;
use App\Models\Room;
use App\Models\ServiceStaff;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LiveWalkIn extends Component
{
    public $counter;
    public $room;
    public $inhouse;
    public $customers;
    public $staffs = [];
    public $baseCurrency;
    public $currencies;
    public $currencyExchanges;
    public $showWalkInForm = false;

    public $arrival;
    public $departure;
    public $arrivalDate;
    public $arrivalTime;
    public $departureDate;
    public $departureTime;

    public $editingStaff = false;
    public $editingStaffSessionHours = 0.5;
    public $editingStaffMin;
    public $editingStaffMax;
    public $editingStaffName;
    public $editingStaffId;
    public $editingStaffArrival;
    public $editingStaffDeparture;
    public $editingStaffArrivalDate;
    public $editingStaffArrivalTime;
    public $editingStaffDepartureDate;
    public $editingStaffDepartureTime;
    public $showStaffTimeAdjustmentModal = false;


    protected $listeners = ['createWalkIn', 'checkInAddServiceStaffs'];

    protected $rules = [
        'inhouse.room_id' => 'required|integer',
        'inhouse.room_rate' => 'required|between:0,999999999.99',
        'inhouse.arrival' => 'required|date',
        'inhouse.departure' => 'required|date',
        'inhouse.session_hours' => 'required|between:0,99.99',
        'inhouse.customer_id' => 'nullable|integer',
        'inhouse.operation_date' => 'required|date',
        'inhouse.created_user_id' => 'required|integer',
    ];

    public function checkIn()
    {
        $this->inhouse->arrival = $this->arrivalDate.' '.$this->arrivalTime;
        $this->inhouse->departure = $this->departureDate.' '.$this->departureTime;

        $this->validate();

        $this->inhouse->save();

        $this->inhouse->refresh();

        if (count($this->staffs) > 0) {
            foreach ($this->staffs as $staff) {
                $this->inhouse->inhouseServices()->create([
                    'service_staff_id' => $staff['id'],
                    'checkin_time' => Carbon::parse($staff['arrival']),
                    'checkout_time' => Carbon::parse($staff['departure']),
                    'session_hours' => $staff['sessions'],
                    'service_staff_rate' => $staff['service_staff_rate'],
                    'operation_date' => app('OperationDate'),
                ]);
            }
        }


        $this->emit('checkInCreated');
        $this->showWalkInForm = false;
    }

    public function updatedEditingStaffArrivalTime($val)
    {
        $this->editingStaffSessionHours = round(Carbon::parse($this->editingStaffArrivalTime)->diffInMinutes($this->editingStaffDepartureTime) / 60, 1);
        // if ($val > Carbon::parse($this->arrivalTime)->addMinutes(30)) {
        // } else {
        //     $this->editingStaffArrivalTime = Carbon::parse($this->arrivalTime)->format("H:i");
        // }
    }

    public function updateStaffTimeChanges()
    {
        $this->staffs[$this->editingStaffId]['arrival'] = Carbon::parse($this->editingStaffArrivalDate.' '.$this->editingStaffArrivalTime)->format('Y-m-d g:i A');
        $this->staffs[$this->editingStaffId]['departure'] = Carbon::parse($this->editingStaffDepartureDate.' '.$this->editingStaffDepartureTime)->format('Y-m-d g:i A');
        $this->staffs[$this->editingStaffId]['sessions'] = $this->editingStaffSessionHours;

        $this->showStaffTimeAdjustmentModal = false;
    }

    public function changeStaffSessionHours($isAddition = true)
    {
        if ($isAddition) {
            $this->editingStaffSessionHours+= .5;
            $this->editingStaffDeparture = Carbon::parse($this->editingStaffArrival)->addMinutes(60 * $this->editingStaffSessionHours);
            $this->editingStaffDepartureTime = $this->editingStaffDeparture->format('H:i');
        } else {
            $this->editingStaffSessionHours-= .5;
            $this->editingStaffDeparture = Carbon::parse($this->editingStaffArrival)->addMinutes(60 * $this->editingStaffSessionHours);
            $this->editingStaffDepartureTime = $this->editingStaffDeparture->format('H:i');
        }
    }

    public function clickShowStaffTimeAdjustmentModal($id)
    {
        $this->editingStaff = true;
        $this->editingStaffId = $id;
        $this->editingStaffName = $this->staffs[$id]['nick_name'];

        $this->editingStaffSessionHours = $this->inhouse->session_hours;

        $this->editingStaffMin = Carbon::parse($this->arrivalTime)->format('H:i');
        $this->editingStaffMax = Carbon::parse($this->departureTime)->format('H:i');

        $this->editingStaffArrival = Carbon::parse($this->staffs[$id]['arrival']);
        $this->editingStaffDeparture = Carbon::parse($this->staffs[$id]['departure']);
        $this->editingStaffArrivalDate = Carbon::parse($this->staffs[$id]['arrival'])->format('Y-m-d');
        $this->editingStaffArrivalTime = Carbon::parse($this->staffs[$id]['arrival'])->format('H:i');
        $this->editingStaffDepartureDate = Carbon::parse($this->staffs[$id]['departure'])->format('Y-m-d');
        $this->editingStaffDepartureTime = Carbon::parse($this->staffs[$id]['departure'])->format('H:i');

        $this->showStaffTimeAdjustmentModal = true;
    }

    public function removeStaff($id)
    {
        if (isset($this->staffs[$id])) {
            unset($this->staffs[$id]);
            $this->staffs = array_values($this->staffs);
        }
    }

    public function checkInAddServiceStaffs($staffs)
    {
        $staffs = ServiceStaff::whereIn('id', $staffs)->get();
        foreach ($staffs as $staff) {
            if (!isset($this->staffs[$staff->id])) {
                $this->staffs[$staff->id] = [
                    'id' => $staff->id,
                    'nick_name' => $staff->nick_name,
                    'arrival' => Carbon::parse($this->arrivalDate.' '.$this->arrivalTime)->format('Y-m-d g:i A'),
                    'departure' => Carbon::parse($this->departureDate.' '.$this->departureTime)->format('Y-m-d g:i A'),
                    'sessions' => $this->inhouse->session_hours,
                    'service_staff_rate' => app('ServiceStaffRate'),
                ];
            }
        }
    }

    public function changeSessionHours($isAddition = true)
    {
        if ($isAddition) {
            $this->inhouse->session_hours += .5;
            $this->departure = now()->addMinutes(60 * $this->inhouse->session_hours);
            $this->departureDate = $this->departure->format('Y-m-d');
            $this->departureTime =  $this->departure->format('H:i');
        } else {
            $this->inhouse->session_hours -= .5;
            $this->departure = now()->addMinutes(60 * $this->inhouse->session_hours);
            $this->departureDate = $this->departure->format('Y-m-d');
            $this->departureTime =  $this->departure->format('H:i');
        }
    }

    public function createWalkIn(Room $room)
    {
        $this->resetValidation();
        $this->reset();

        $this->customers = Customer::all('id', 'customer_name');
        $this->room = $room->load('type');
        $this->inhouse = new Inhouse();


        $this->inhouse->room_id = $room->id;
        $this->inhouse->room_rate = $room->type->room_rate;
        $this->inhouse->session_hours = 1;
        $this->inhouse->operation_date = app('OperationDate');
        // Datetime for formatted for Flatpickr
        $this->arrival = now();
        $this->departure = now()->addHour();
        $this->arrivalDate = $this->arrival->format('Y-m-d');
        $this->arrivalTime = $this->arrival->format('H:i');

        $this->departureDate = $this->departure->format('Y-m-d');
        $this->departureTime = $this->departure->format('H:i');

        $this->inhouse->created_user_id = auth()->id();

        $this->showWalkInForm = true;
    }

    public function render()
    {
        return view('livewire.live-walk-in');
    }
}
