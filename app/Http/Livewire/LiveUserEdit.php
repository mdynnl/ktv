<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Role;
use App\Models\Honorific;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveUserEdit extends Component
{
    use WithFileUploads;

    public User $user;
    public $image;
    public $role;
    public $roles;

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

    public function updateUser()
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

    public function mount(User $user)
    {
        $this->fill($user);

        $this->user = $user->load('roles');
        $this->role = $this->user->hasAnyRole(Role::all()) ? $this->user->roles->first()->id : null;
        $this->updated_user_id = auth()->id();

        $this->roles = Role::all('id', 'name');
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
