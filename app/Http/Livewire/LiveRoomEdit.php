<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomEdit extends Component
{
    use AuthorizesRequests;

    public $room;
    public $roomTypes;
    public $showRoomEditForm = false;

    protected $listeners = ['editRoom'];

    protected function rules()
    {
        return [
            'room.room_type_id' => 'required|integer',
            'room.room_no' => 'required|string|unique:rooms,room_no,'.$this->room->id,
            'room.created_user_id' => 'required|integer',
        ];
    }

    public function update()
    {
        $this->room->updated_user_id = auth()->id();

        $this->validate();

        $this->room->update();

        $this->emit('roomUpdated');

        $this->showRoomEditForm = false;
    }

    public function editRoom(Room $room)
    {
        $this->authorize('update', $room);
        $this->resetValidation();
        $this->reset();

        $this->room = $room;
        $this->roomTypes = RoomType::all('id', 'room_type_name');

        $this->showRoomEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-room-edit');
    }
}
