<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use App\Models\Room;
use App\Models\RoomTransfer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveRoomTransfer extends Component
{
    // public ?RoomTransfer $roomTransfer = null;
    public $inhouse;
    public $rooms;
    public $fromRoom;
    public $toRoom;
    public $showRoomTransferForm = false;
    public $currencyCode;

    public $arrivalDate;
    public $departureDate;

    protected $listeners = ['createRoomTransfer'];

    protected $rules = [
        'roomTransfer.operation_date' => 'required|date',
        'roomTransfer.inhouse_id' => 'required|integer',
        'roomTransfer.from_room_no' => 'required|integer',
        'roomTransfer.from_room_rate' => 'required|between:0,999999999.99',
        'roomTransfer.to_room_no' => 'required|integer',
        'roomTransfer.to_room_rate' => 'required|between:0,999999999.99',
        'roomTransfer.remark' => 'nullable|string',
        'roomTransfer.created_user_id' => 'required|integer',
    ];

    public function saveRoomTransfer()
    {
        $this->validate();


        DB::transaction(function () {
            $this->roomTransfer->save();

            $this->inhouse->room->update([
                'housekeeping_status_id' => 2
            ]);

            $this->inhouse->update([
                'room_no' => $this->roomTransfer->to_room_no,
                'room_rate' => $this->roomTransfer->to_room_rate,
                'updated_user_id' => auth()->id()
            ]);
        }, 3);

        $this->emit('roomTransferred');
        $this->closeRoomTransferForm();
    }

    public function updatedRoomTransferToRoomNo($no)
    {
        $this->toRoom = $this->rooms->where('room_no', $no)->first();

        if ($this->checkReservations()) {
            if ($this->currencyCode == 'MMK') {
                $this->roomTransfer->to_room_rate = $this->toRoom->type->room_rate_mmk;
            } else {
                $this->roomTransfer->to_room_rate = $this->toRoom->type->room_rate_usd;
            }
        }
    }

    public function closeRoomTransferForm()
    {
        $this->showRoomTransferForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function createRoomTransfer(Inhouse $inhouse)
    {
        // $this->roomTransfer = new RoomTransfer();
        $this->rooms = Room::with('type')->get();
        $this->inhouse = $inhouse->load('room.type');
        $this->arrivalDate = Carbon::parse($this->inhouse->arrival)->format('Y-m-d');
        $this->departureDate = Carbon::parse($this->inhouse->departure)->format('Y-m-d');
        $this->fromRoom = $this->inhouse->room;

        // $this->roomTransfer->operation_date = today()->toDateString();
        // $this->roomTransfer->inhouse_id = $this->inhouse->id;
        // $this->roomTransfer->from_room_no = $this->inhouse->room_no;
        // $this->roomTransfer->from_room_rate = $this->inhouse->room_rate;

        // $this->roomTransfer->created_user_id = auth()->id();
        $this->showRoomTransferForm = true;
    }

    protected function checkReservations()
    {
        $available = true;

        if ($this->toRoom->inhouses->where('checked_out', false)->first() !== null) {
            $available = false;
        }

        if ($available) {
            $reservations = $this->toRoom->reservations->where('reservation_status_id', '!=', 2);

            foreach ($reservations as $reservation) {
                if (
                    ($this->arrivalDate  >= $reservation->arrival->format('Y-m-d')) && ($this->arrivalDate  <  $reservation->departure->format("Y-m-d"))
                    || ($this->departureDate  > $reservation->arrival->format('Y-m-d')) && ($this->departureDate  <  $reservation->departure->format("Y-m-d"))
                    || ($this->arrivalDate  < $reservation->arrival->format('Y-m-d')) && ($this->departureDate  >  $reservation->departure->format("Y-m-d"))
                ) {
                    $available = false;
                }
            }
        }

        if ($available) {
            $this->dispatchBrowserEvent('success-message', ['message' => "Room {$this->toRoom->room_no} available $this->arrivalDate - $this->departureDate"]);
            return $available;
        } else {
            $this->dispatchBrowserEvent('unsuccess-message', ['message' => "Room {$this->toRoom->room_no} not available $this->arrivalDate - $this->departureDate"]);
            return $available;
        }
    }
}
