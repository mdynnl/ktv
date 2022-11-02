<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\IncomeTransaction;
use App\Models\Inhouse;
use App\Models\InhouseService;
use App\Models\ServiceStaff;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Livewire\Component;

class LiveInhouseEdit extends Component
{
    use AuthorizesRequests;

    public $counter;
    public $room;
    public $inhouseId;
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
    public $editingStaffIndex;
    public $editingInhouseServiceId;
    public $staffSessionsPassed = 0;
    public $staffRemainingSessions = 0;
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

    public $incomeTransactions;

    public $orderDetails;

    // States
    public $showInhouseEditForm = false;
    public $sessionsPassed;
    public $remainingTime;
    public $remainingSessions;
    public $decimals = 0;
    public $isDirty = false;
    public $isStaffListDirty = false;
    public $isPaid = false;
    public $editingTransactionId;
    public $editingTransactionName;
    public $editingTransactionAmount;
    public $editingTransactionRemark;
    public $showTransactionRemoveConfirmationModal = false;
    public $showServiceStaffRemoveConfirmationModal = false;

    protected $listeners = [
            'editInhouse',
            'inhouseServiceStaffAdded',
            'inhouseEditAddServiceStaffs',
            'orderPlaced',
            'incomeTransactionAdded',
            'checkOutPaymentsSettled',
            'roomTransferred'
        ];

    protected $rules = [
        'inhouse.room_id' => 'required|integer',
        'inhouse.room_rate' => 'required|between:0,999999999.99',
        'inhouse.arrival' => 'required|date',
        'inhouse.departure' => 'required|date',
        'inhouse.session_hours' => 'required|between:0,99.99',
        'inhouse.customer_id' => 'nullable|integer',
        'inhouse.updated_user_id' => 'required|integer',
    ];

    public function inhouseServiceStaffAdded()
    {
        $inhouseServices = $this->inhouse->inhouseServices->load('serviceStaff');
        foreach ($inhouseServices as $service) {
            array_push($this->staffs, [
                'id' => $service->serviceStaff->id,
                'inhouse_service_id' => $service->id,
                'nick_name' => $service->serviceStaff->nick_name,
                'arrival' => $service->checkin_time->format('Y-m-d g:i A'),
                'departure' => $service->checkout_time->format('Y-m-d g:i A'),
                'sessions' => $service->session_hours,
                'service_staff_rate' => $service->service_staff_rate,
                'service_staff_commission_rate' => $service->service_staff_commission_rate,
            ]);
        }
    }

    public function roomTransferred()
    {
        $this->editInhouse($this->inhouse->refresh());
    }

    public function checkOut()
    {
        $this->inhouse->update([
            'checked_out' => true
        ]);

        $this->emit('roomCheckedOut');
        $this->showInhouseEditForm = false;
    }

    public function checkOutPaymentsSettled()
    {
        $this->isPaid = true;
    }

    public function incomeTransactionAdded()
    {
        $this->incomeTransactions = $this->inhouse->incomeTransactions;
    }

    public function update()
    {
        if ($this->isPaid) {
            return;
        }
        $this->inhouse->arrival = $this->arrivalDate.' '.$this->arrivalTime;
        $this->inhouse->departure = $this->departureDate.' '.$this->departureTime;

        $this->validate();

        $this->inhouse->update();

        $updatableServices = array_filter($this->staffs, fn ($staff) => !is_null($staff['inhouse_service_id']));

        if (count($updatableServices) > 0) {
            foreach ($updatableServices as $service) {
                InhouseService::find($service['inhouse_service_id'])->update([
                    'checkin_time' => $service['arrival'],
                    'checkout_time' => $service['departure'],
                    'session_hours' => $service['sessions'],
                ]);
            }
        }

        $newServices = array_filter($this->staffs, fn ($staff) => is_null($staff['inhouse_service_id']));

        if (count($newServices) > 0) {
            foreach ($newServices as $service) {
                InhouseService::create([
                    'inhouse_id' => $this->inhouseId,
                    'service_staff_id' => $service['id'],
                    'checkin_time' => $service['arrival'],
                    'checkout_time' => $service['departure'],
                    'session_hours' => $service['sessions'],
                    'operation_date' => app('OperationDate'),
                    'service_staff_rate' => $service['service_staff_rate'],
                    'service_staff_commission_rate' => $service['service_staff_commission_rate'],
                ]);
            }
        }

        $this->emit('inhouseEdited');
        // $this->showInhouseEditForm = false;
    }

    public function confirmDeleteTransaction()
    {
        if (!$this->isPaid) {
            IncomeTransaction::find($this->editingTransactionId)->delete();
            $this->incomeTransactions = Inhouse::find($this->inhouseId)->incomeTransactions;
            $this->showTransactionRemoveConfirmationModal = false;
        }
    }

    public function removeTransaction($transactionId)
    {
        if (!$this->isPaid) {
            $incomeTransaction = IncomeTransaction::with('transaction')->find($transactionId);
            $this->editingTransactionId =  $transactionId;
            $this->editingTransactionName = $incomeTransaction->transaction->transaction_name;
            $this->editingTransactionAmount = $incomeTransaction->amount;
            $this->editingTransactionRemark = $incomeTransaction->remark;

            $this->showTransactionRemoveConfirmationModal = true;
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

    protected function updateDepartureDateTime()
    {
        $sessions = $this->inhouse->session_hours;
        $sessionInMinutes = $sessions * 60;
        $arrival = Carbon::parse($this->arrivalDate . ' ' . $this->arrivalTime);
        $departure = $arrival->addMinutes($sessionInMinutes);
        $this->departureDate = $departure->format('Y-m-d');
        $this->departureTime = $departure->format('H:i');
        $this->update();
    }

    protected function checkDateIsValid()
    {
        $isValid = false;
        $arrival = Carbon::parse($this->arrivalDate . ' ' . $this->arrivalTime);

        $departure = Carbon::parse($this->departureDate . ' '. $this->departureTime);

        if ($arrival > $departure) {
            $isValid = false;
            $this->dispatchBrowserEvent('unsuccess-inhouse-message', ['message' => "Selected Date/Time invalid!"]);
        } else {
            $isValid = true;
            $this->dispatchBrowserEvent('success-inhouse-message', ['message' => "cc"]);
        };

        return $isValid;
    }

    public function updatedInhouseCustomerId()
    {
        $this->update();
    }

    public function confirmDeleteServiceStaff()
    {
        $this->showServiceStaffRemoveConfirmationModal = false;
        InhouseService::find($this->editingInhouseServiceId)->delete();

        unset($this->staffs[$this->editingStaffIndex]);
        $this->staffs = array_values($this->staffs);
    }

    public function removeStaff($index)
    {
        if (isset($this->staffs[$index]['inhouse_service_id'])) {
            $this->editingStaffIndex = $index;
            $this->editingStaffName = $this->staffs[$index]['nick_name'];
            $this->editingInhouseServiceId = $this->staffs[$index]['inhouse_service_id'];
            $this->showServiceStaffRemoveConfirmationModal = true;
        } else {
            if (isset($this->staffs[$index])) {
                unset($this->staffs[$index]);
                $this->staffs = array_values($this->staffs);
            }
        }
    }


    public function inhouseEditAddServiceStaffs($staffs)
    {
        if ($this->isPaid) {
            return;
        }
        $staffs = ServiceStaff::whereIn('id', $staffs)->get();
        foreach ($staffs as $staff) {
            $exists = array_search($staff->id, array_column($this->staffs, 'id'));
            if (is_bool($exists)) {
                $departure = Carbon::parse($this->departureDate.' '.$this->departureTime)->format('Y-m-d g:i A');
                $sessions = round(now()->diffInMinutes($this->departureTime) / 60, 1);
                array_push($this->staffs, [
                    'id' => $staff->id,
                    'inhouse_service_id' => null,
                    'nick_name' => $staff->nick_name,
                    'arrival' => now()->format('Y-m-d g:i A'),
                    'departure' => $departure,
                    'sessions' => $sessions,
                    'service_staff_rate' => app('ServiceStaffRates')->service_staff_rate,
                    'service_staff_commission_rate' => app('ServiceStaffRates')->service_staff_commission_rate,
                ]);

                // $this->isStaffListDirty = true;
                // $this->isDirty = true;
            }
        }
        $this->update();
    }

    public function changeStaffSessionHours($isAddition = true)
    {
        if ($this->isPaid) {
            return;
        }
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

    public function updateStaffTimeChanges()
    {
        $this->staffs[$this->editingStaffIndex]['arrival'] = Carbon::parse($this->editingStaffArrivalDate.' '.$this->editingStaffArrivalTime)->format('Y-m-d g:i A');
        $this->staffs[$this->editingStaffIndex]['departure'] = Carbon::parse($this->editingStaffDepartureDate.' '.$this->editingStaffDepartureTime)->format('Y-m-d g:i A');
        $this->staffs[$this->editingStaffIndex]['sessions'] = $this->editingStaffSessionHours;
        $this->update();

        $this->showStaffTimeAdjustmentModal = false;
    }

    public function editServiceStaff($index)
    {
        $this->editingStaff = true;
        $this->editingStaffIndex = $index;
        $this->editingStaffId = $this->staffs[$index]['id'];
        $this->editingStaffName = $this->staffs[$index]['nick_name'];

        $this->editingStaffSessionHours = $this->staffs[$index]['sessions'];

        $this->editingStaffMin = Carbon::parse($this->arrivalTime)->format('H:i');
        $this->editingStaffMax = Carbon::parse($this->departureTime)->format('H:i');

        $this->editingStaffArrival = Carbon::parse($this->staffs[$index]['arrival']);
        $this->editingStaffDeparture = Carbon::parse($this->staffs[$index]['departure']);
        $this->editingStaffArrivalDate = Carbon::parse($this->staffs[$index]['arrival'])->format('Y-m-d');
        $this->editingStaffArrivalTime = Carbon::parse($this->staffs[$index]['arrival'])->format('H:i');
        $this->editingStaffDepartureDate = Carbon::parse($this->staffs[$index]['departure'])->format('Y-m-d');
        $this->editingStaffDepartureTime = Carbon::parse($this->staffs[$index]['departure'])->format('H:i');

        $this->staffSessionsPassed = round(now()->diffInMinutes($this->editingStaffArrival) / 60, 1);
        $this->staffRemainingSessions = $this->editingStaffSessionHours - $this->sessionsPassed;

        $this->showStaffTimeAdjustmentModal = true;
    }

    public function changeSessionHours($isAddition = true)
    {
        if ($this->isPaid) {
            return;
        }
        if ($isAddition) {
            $this->remainingSessions += .5;
            $this->inhouse->session_hours += .5;
            $this->departure = Carbon::parse($this->departure)->addMinutes(60 * 0.5);
            $this->departureDate = $this->departure->format('Y-m-d');
            $this->departureTime =  $this->departure->format('H:i');
            // $this->setUpDisplayRemainder();
            $this->changeStaffSessions($isAddition);
            $this->update();
        // $this->isDirty = true;
        } else {
            if ($this->sessionsPassed >= 1 && $this->remainingSessions > .5) {
                $this->remainingSessions -= .5;
                $this->inhouse->session_hours -= .5;
                // $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5)->format('Y-m-d H:i');
                $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5);
                $this->departureDate = $this->departure->format('Y-m-d');
                $this->departureTime =  Carbon::parse($this->departure)->format('H:i');
                // $this->setUpDisplayRemainder();
                $this->changeStaffSessions($isAddition);
                $this->update();
            // $this->isDirty = true;
            } elseif ($this->remainingSessions > 1) {
                $this->decimals = $this->remainingSessions - floor($this->remainingSessions);
                $this->remainingSessions -= .5;
                $this->inhouse->session_hours -= .5;
                // $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5)->format('Y-m-d H:i');
                $this->departure = Carbon::parse($this->departure)->subMinutes(60 * 0.5);
                $this->departureDate = $this->departure->format('Y-m-d');
                $this->departureTime =  Carbon::parse($this->departure)->format('H:i');
                // $this->setUpDisplayRemainder();
                $this->changeStaffSessions($isAddition);
                $this->update();
                // $this->isDirty = true;
            }
        }
    }

    // public function updated()
    // {
    //     $this->update();
    // }

    public function changeStaffSessions($isAddition)
    {
        if (!$this->isPaid) {
            for ($i=0; $i < count($this->staffs); $i++) {
                if ($isAddition) {
                    $departure = Carbon::parse($this->staffs[$i]['departure'])->addMinutes(60 * 0.5);
                    $this->staffs[$i]['departure'] = $departure->format('Y-m-d g:i A');
                    $this->staffs[$i]['sessions']+= 0.5;
                    $this->isStaffListDirty = true;
                } else {
                    $departure = Carbon::parse($this->staffs[$i]['departure'])->subMinutes(60 * 0.5);
                    $this->staffs[$i]['departure'] = $departure->format('Y-m-d g:i A');
                    $this->staffs[$i]['sessions']-= 0.5;
                    $this->isStaffListDirty = true;
                }
            }
        }
    }

    public function orderPlaced()
    {
        // $order = $this->room->table->orders->where('is_paid', false)->first();
        $order = $this->inhouse->order;
        if (!is_null($order)) {
            $this->orderDetails = $order->orderDetails()->with('food')->get();
        }
    }

    public function editInhouse(Inhouse $inhouse)
    {
        $this->authorize('edit inhouse');
        $this->resetValidation();
        $this->reset();

        $this->inhouseId = $inhouse->id;
        $this->inhouse = $inhouse->load('room.type');
        $this->isPaid = $inhouse->checkout_payment_done;
        $this->incomeTransactions = $this->inhouse->incomeTransactions;


        $inhouseServices = $this->inhouse->inhouseServices->load('serviceStaff');
        foreach ($inhouseServices as $service) {
            array_push($this->staffs, [
                'id' => $service->serviceStaff->id,
                'inhouse_service_id' => $service->id,
                'nick_name' => $service->serviceStaff->nick_name,
                'arrival' => $service->checkin_time->format('Y-m-d g:i A'),
                'departure' => $service->checkout_time->format('Y-m-d g:i A'),
                'sessions' => $service->session_hours,
                'service_staff_rate' => $service->service_staff_rate,
                'service_staff_commission_rate' => $service->service_staff_commission_rate,
            ]);
        }

        $this->room = $this->inhouse->room;
        $this->customers = Customer::all('id', 'customer_name');

        // dd(Carbon::parse($this->inhouse->departure)->diff(now()));
        // $this->remainingTime = now()->diff($this->inhouse->departure);
        $this->setUpDisplayRemainder();
        $this->sessionsPassed = round(now()->diffInMinutes($this->inhouse->arrival) / 60, 1);
        $this->remainingSessions = $this->inhouse->session_hours - $this->sessionsPassed;
        $this->arrival = $this->inhouse->arrival;
        $this->departure = $this->inhouse->departure;

        $this->arrivalDate = Carbon::parse($this->arrival)->format('Y-m-d');
        $this->arrivalTime = Carbon::parse($this->arrival)->format('H:i');

        $this->departureDate = Carbon::parse($this->departure)->format('Y-m-d');
        $this->departureTime = Carbon::parse($this->departure)->format('H:i');

        $this->inhouse->updated_user_id = auth()->id();

        // $order = $this->room->table->orders->where('is_paid', false)->first();
        $order = $this->inhouse->order;
        if (!is_null($order)) {
            $this->orderDetails = $order->orderDetails()->with('food')->get();
        }

        $this->showInhouseEditForm = true;
    }

    protected function setUpDisplayRemainder()
    {
        if (now()->diffInMinutes($this->inhouse->departure, false) > 60) {
            $this->remainingTime = now()->diff($this->inhouse->departure)->format('%hhrs %imins');
        } elseif (now()->diffInMinutes($this->inhouse->departure, false) <= 0) {
            $this->remainingTime = "Time's Up";
        } else {
            $this->remainingTime = now()->diff($this->inhouse->departure)->format('%imins');
        }
    }

    public function render()
    {
        return view('livewire.live-inhouse-edit');
    }
}
