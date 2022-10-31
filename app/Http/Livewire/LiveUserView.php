<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class LiveUserView extends Component
{
    public function render()
    {
        return view('livewire.live-user-view', [
            'users' => User::with('roles')->get()
        ]);
    }
}
