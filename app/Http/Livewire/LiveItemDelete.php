<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Database\QueryException;
use Livewire\Component;

class LiveItemDelete extends Component
{
    public $item;
    public $showItemDeleteModal = false;

    protected $listeners = ['deleteItem'];

    public function delete()
    {
        try {
            $this->item->delete();
            $this->emit('itemDeleted');
            $this->showItemDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showRoomDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Item Delete Unsuccessful", 'body' => "Cannot delete item cause other related data exist. Please delete related data first to delete this item."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteItem(Item $item)
    {
        $this->item = $item;
        $this->showItemDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-item-delete');
    }
}
