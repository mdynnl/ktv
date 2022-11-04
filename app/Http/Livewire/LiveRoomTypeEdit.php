<?php

namespace App\Http\Livewire;

use App\Models\RoomType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomTypeEdit extends Component
{
    use AuthorizesRequests;

    public $roomType;
    public $showRoomTypeEditForm = false;

    protected $listeners = ['editRoomType'];

    protected $rules = [
        'roomType.room_type_name' => 'required|string',
        'roomType.room_rate' => 'required|between:0,999999999.99',
        'roomType.created_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->roomType->updated_user_id = auth()->id();

        $this->validate();

        $this->roomType->update();

        $this->emit('roomTypeUpdated');
        $this->showRoomTypeEditForm = false;
    }

    public function editRoomType(RoomType $roomType)
    {
        $this->authorize('update', $roomType);
        $this->resetValidation();
        $this->reset();

        $this->roomType = $roomType;

        $this->showRoomTypeEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-room-type-edit');
    }
}
