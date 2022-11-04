<?php

namespace App\Http\Livewire;

use App\Models\Room;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomDelete extends Component
{
    use AuthorizesRequests;

    public $room;
    public $showRoomDeleteModal = false;

    protected $listeners = ['deleteRoom'];

    public function delete()
    {
        try {
            $this->room->delete();
            $this->emit('roomDeleted');
            $this->showRoomDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showRoomDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Room Delete Unsuccessful", 'body' => "Cannot delete Room {$this->room->room_no} cause other related data exist. Please delete related data first to delete this room."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteRoom(Room $room)
    {
        $this->authorize('delete', $room);

        $this->room = $room;

        $this->showRoomDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-room-delete');
    }
}
