<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveUserPasswordChange extends Component
{
    use AuthorizesRequests;

    public $user;
    public $current_password;
    public $password;
    public $password_confirmation;

    public $showChangePasswordForm = false;

    protected $listeners = ['changePassword'];

    protected $rules = [
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed'],
    ];

    public function update()
    {
        $validated = $this->validate();

        $this->user->update([
            'password' => bcrypt($validated['password']),
            'updated_user_id' => auth()->id(),
        ]);

        auth()->logout();

        return redirect('login');
    }


    public function changePassword(User $user)
    {
        $this->authorize('update', $user);

        $this->resetValidation();
        $this->reset();

        $this->user = $user;
        $this->showChangePasswordForm = true;
    }


    public function render()
    {
        return view('livewire.live-user-password-change');
    }
}
