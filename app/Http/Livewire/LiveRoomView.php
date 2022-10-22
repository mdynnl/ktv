<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;

class LiveRoomView extends Component
{
    public $search = '';
    public $selectedTypeId;


    protected $listeners = [
        'roomTypeCreated' => '$refresh',
        'roomTypeUpdated' => '$refresh',
        'roomTypeDeleted' => '$refresh',
        'roomCreated' => '$refresh',
        'roomUpdated' => '$refresh',
        'roomDeleted' => '$refresh',
    ];

    public function mount()
    {
        $this->selectedTypeId = RoomType::all('id')->first()->id;
    }

    public function render()
    {
        return view('livewire.live-room-view', [
            'roomTypes' => RoomType::all('id', 'room_type_name', 'room_rate'),
            'rooms' => Room::with('type')->when(strlen($this->search) > 0 ? $this->search : false, function ($query) {
                $query->where('room_no', 'like', '%'.$this->search.'%');
            })
            ->where('room_type_id', $this->selectedTypeId)
            ->get()
        ]);
    }
}
