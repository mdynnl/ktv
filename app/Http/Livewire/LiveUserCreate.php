<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Role;
use App\Models\Honorific;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveUserCreate extends Component
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
    public $created_user_id;

    protected $rules = [
        // 'image' => 'nullable|image|max:512',
        'name' => 'required|string',
        'username' => 'required|string',
        'gender' => 'required|string',
        'nrc' => 'required|string',
        'dob' => 'nullable|date',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string',
        'address' => 'nullable|string',
        'password' => 'required|string',
        'created_user_id' => 'required|integer'
    ];


    public function createUser()
    {
        $validated = $this->validate();
        $validated['password'] = bcrypt($validated['password']);

        DB::transaction(function () use ($validated) {
            if ($this->image) {
                $imagePath = $this->image->store('avatars');
                $validated['image'] = $imagePath;
            }
            $user = User::create($validated);
            $user->assignRole($this->role);
        });


        return redirect()->route('users');
    }

    public function mount()
    {
        $this->roles = Role::all('id', 'name');
        $this->created_user_id = auth()->id();
    }

    public function render()
    {
        return view('livewire.live-user-create');
    }
}
