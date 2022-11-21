<?php

namespace App\Http\Livewire;

use App\Models\Gender;
use App\Models\Role;
use App\Models\Honorific;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveUserCreate extends Component
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
    public $created_user_id;

    public $showUserCreateForm = false;

    protected $listeners = ['createUser'];

    protected $rules = [
        // 'image' => 'nullable|image|max:512',
        'name' => 'required|string',
        'username' => 'required|string',
        'gender' => 'nullable|string',
        'role' => 'required|string',
        'nrc' => 'nullable|string',
        'dob' => 'nullable|date',
        'email' => 'nullable|email|unique:users,email',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'password' => 'required|string|min:8',
        'created_user_id' => 'required|integer'
    ];


    public function create()
    {
        $validated = $this->validate();
        unset($validated['role']);
        $validated['password'] = bcrypt($validated['password']);

        DB::transaction(function () use ($validated) {
            if ($this->image) {
                $imagePath = $this->image->store('avatars');
                $validated['image'] = $imagePath;
            }
            $user = User::create($validated);
            $user->assignRole($this->role);
        });


        $this->emit('userCreated');
        $this->showUserCreateForm = false;
    }

    public function createUser()
    {
        $this->authorize('create', User::class);

        $this->resetValidation();
        $this->reset();

        $this->roles = Role::all('id', 'name');
        $this->created_user_id = auth()->id();
        $this->showUserCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-user-create');
    }
}
