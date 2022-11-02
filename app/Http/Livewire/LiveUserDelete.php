<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveUserDelete extends Component
{
    use AuthorizesRequests;

    public $user;
    public $showUserDeleteModal = false;

    protected $listeners = ['deleteUser'];

    public function delete()
    {
        try {
            $this->user->delete();
            $this->emit('userDeleted');
            $this->showUserDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showUserDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "User Delete Unsuccessful", 'body' => "Cannot delete user cause other related data exist. Please delete related data first to delete this user."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteUser(User $user)
    {
        $this->authorize('delete', $user);

        $this->user = $user;
        $this->showUserDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-user-delete');
    }
}
