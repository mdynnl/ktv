<?php

namespace App\Http\Livewire;

use App\Models\RoomType;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRoomTypeDelete extends Component
{
    use AuthorizesRequests;

    public $roomType;
    public $showRoomTypeDeleteModal = false;

    protected $listeners = ['deleteRoomType'];

    public function delete()
    {
        try {
            $this->roomType->delete();
            $this->emit('roomTypeDeleted');
            $this->showRoomTypeDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showRoomTypeDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Room Type Delete Unsuccessful", 'body' => "Cannot delete Room Type {$this->roomType->room_type_name} cause other related data exist. Please delete related data first to delete this room type."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteRoomType(RoomType $roomType)
    {
        $this->authorize('delete', $roomType);
        $this->roomType = $roomType;

        $this->showRoomTypeDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-room-type-delete');
    }
}
