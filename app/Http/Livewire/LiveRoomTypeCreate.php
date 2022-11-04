<?php

namespace App\Http\Livewire;

use App\Models\RoomType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomTypeCreate extends Component
{
    use AuthorizesRequests;

    public $roomType;
    public $showRoomTypeCreateForm = false;

    protected $listeners = ['createRoomType'];

    protected $rules = [
        'roomType.room_type_name' => 'required|string',
        'roomType.room_rate' => 'required|between:0,999999999.99',
        'roomType.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->roomType->created_user_id = auth()->id();

        $this->validate();

        $this->roomType->save();

        $this->emit('roomTypeCreated');
        $this->showRoomTypeCreateForm = false;
    }

    public function createRoomType()
    {
        $this->authorize('create', RoomType::class);
        $this->resetValidation();
        $this->reset();

        $this->roomType = new RoomType();

        $this->showRoomTypeCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-room-type-create');
    }
}
