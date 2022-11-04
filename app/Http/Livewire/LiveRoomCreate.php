<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomCreate extends Component
{
    use AuthorizesRequests;

    public $room;
    public $showRoomCreateForm = false;

    protected $listeners = ['createRoom'];

    protected $rules = [
        'room.room_type_id' => 'required|integer',
        'room.room_no' => 'required|string|unique:rooms,room_no',
        'room.created_user_id' => 'required|integer',
    ];


    public function create()
    {
        $this->room->created_user_id = auth()->id();

        $this->validate();

        $this->room->save();

        $this->emit('roomCreated');
        $this->showRoomCreateForm = false;
    }

    public function createRoom($id)
    {
        $this->authorize('create', Room::class);

        $this->resetValidation();
        $this->reset();


        $this->room = new Room();
        $this->room->room_type_id = $id;

        $this->showRoomCreateForm = true;
    }
    public function render()
    {
        return view('livewire.live-room-create', [
            'roomTypes' => RoomType::all('id', 'room_type_name'),
        ]);
    }
}
