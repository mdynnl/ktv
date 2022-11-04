<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Role;
use App\Models\Honorific;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveUserEdit extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $user;
    public $image;
    public $role;
    public $roles = [];

    public $name;
    public $username;
    public $gender;
    public $nrc;
    public $dob;
    public $email;
    public $phone;
    public $address;
    public $password;
    public $updated_user_id;

    public $showUserUpdateForm = false;

    protected $listeners = ['editUser'];

    protected function rules()
    {
        return [
            // 'image' => 'nullable|image|max:512',
            'name' => 'required|string',
            'username' => 'required|string',
            'gender' => 'required|string',
            'nrc' => 'required|string',
            'dob' => 'nullable|date',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string',
            'updated_user_id' => 'required|integer'
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }


        DB::transaction(function () use ($validated) {
            $this->checkAndUpdateImage();
            $this->user->update($validated);
            $this->user->syncRoles($this->role);
        });

        return redirect()->route('users');
    }

    public function editUser(User $user)
    {
        $this->authorize('viewAny', $user);
        $this->resetValidation();
        $this->reset();

        $this->fill($user);

        $this->user = $user->load('roles');
        $this->role = $this->user->hasAnyRole(Role::all()) ? $this->user->roles->first()->id : null;
        $this->updated_user_id = auth()->id();

        $this->roles = Role::all('id', 'name');

        $this->showUserUpdateForm = true;
    }

    public function render()
    {
        return view('livewire.live-user-edit');
    }

    protected function checkAndUpdateImage()
    {
        if ($this->image) {
            if ($this->user->image) {
                Storage::delete($this->user->image);
            }
            $this->user->image = $this->image->store('avatars');
        }
    }
}
