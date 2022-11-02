<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class LiveUserView extends Component
{
    public $search = '';

    protected $listeners = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.live-user-view', [
            'users' => User::with('roles')
            ->when(strlen($this->search) > 1 ? $this->search : false, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('username', 'like', '%'.$this->search.'%');
            })
            ->get()
        ]);
    }
}
