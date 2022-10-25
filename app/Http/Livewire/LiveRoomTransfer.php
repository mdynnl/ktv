<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use App\Models\Room;
use App\Models\RoomTransfer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveRoomTransfer extends Component
{
    public $inhouse;
    public $rooms;
    public $fromRoom;
    public $toRoom;
    public $showRoomTransferForm = false;


    public $selectedRoomIdForTransfer;
    public $remark;

    protected $listeners = ['createRoomTransfer'];

    protected $rules = [
        'selectedRoomIdForTransfer' => 'required|integer',
        'remark' => 'nullable|string'
        // 'roomTransfer.operation_date' => 'required|date',
        // 'roomTransfer.inhouse_id' => 'required|integer',
        // 'roomTransfer.from_room_no' => 'required|integer',
        // 'roomTransfer.from_room_rate' => 'required|between:0,999999999.99',
        // 'roomTransfer.to_room_no' => 'required|integer',
        // 'roomTransfer.to_room_rate' => 'required|between:0,999999999.99',
        // 'roomTransfer.remark' => 'nullable|string',
        // 'roomTransfer.created_user_id' => 'required|integer',
    ];

    public function saveRoomTransfer()
    {
        $this->validate();


        DB::transaction(function () {
            $this->inhouse->update([
                'room_id' => $this->selectedRoomIdForTransfer,
                'room_rate' => $this->toRoom->type->room_rate,
                'remark' => $this->remark,
                'updated_user_id' => auth()->id()
            ]);
        }, 3);

        $this->emit('roomTransferred');
        $this->closeRoomTransferForm();
    }

    public function updatedSelectedRoomIdForTransfer($id)
    {
        $this->toRoom = $this->rooms->where('id', $id)->first();

        $this->checkReservations();

        // if ($this->checkReservations()) {
        //     if ($this->currencyCode == 'MMK') {
        //         $this->roomTransfer->to_room_rate = $this->toRoom->type->room_rate_mmk;
        //     } else {
        //         $this->roomTransfer->to_room_rate = $this->toRoom->type->room_rate_usd;
        //     }
        // }
    }

    public function closeRoomTransferForm()
    {
        $this->showRoomTransferForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function createRoomTransfer(Inhouse $inhouse)
    {
        $this->rooms = Room::select('id', 'room_type_id', 'room_no')->whereNotIn('id', function ($query) {
            $query->select('room_id as id')->from('inhouses')->where('checked_out', false);
        })
        ->with('type:id,room_type_name,room_rate')
        ->get();

        $this->inhouse = $inhouse->load('room.type');
        // $this->arrivalDate = Carbon::parse($this->inhouse->arrival)->format('Y-m-d');
        // $this->departureDate = Carbon::parse($this->inhouse->departure)->format('Y-m-d');
        $this->fromRoom = $this->inhouse->room;

        $this->showRoomTransferForm = true;
    }

    protected function checkReservations()
    {
        $available = true;
        // dd($this->inhouse->room_rate);
        // dd($this->toRoom->type->room_rate);

        if ($this->inhouse->room_rate !== $this->toRoom->type->room_rate) {
            $available = false;
        }

        // if ($this->toRoom->inhouses->where('checked_out', false)->first() !== null) {
        //     $available = false;
        // }

        // if ($available) {
        //     $reservations = $this->toRoom->reservations->where('reservation_status_id', '!=', 2);

        //     foreach ($reservations as $reservation) {
        //         if (
        //             ($this->arrivalDate  >= $reservation->arrival->format('Y-m-d')) && ($this->arrivalDate  <  $reservation->departure->format("Y-m-d"))
        //             || ($this->departureDate  > $reservation->arrival->format('Y-m-d')) && ($this->departureDate  <  $reservation->departure->format("Y-m-d"))
        //             || ($this->arrivalDate  < $reservation->arrival->format('Y-m-d')) && ($this->departureDate  >  $reservation->departure->format("Y-m-d"))
        //         ) {
        //             $available = false;
        //         }
        //     }
        // }

        if ($available) {
            $this->dispatchBrowserEvent('success-message', ['message' => "Room {$this->toRoom->room_no} selected for transfer."]);
            return $available;
        } else {
            $this->dispatchBrowserEvent('unsuccess-message', ['message' => "Room {$this->toRoom->room_no}'s rate is different from current. Check out and check into selected room."]);
            return $available;
        }
    }
}
