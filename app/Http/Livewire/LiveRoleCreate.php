<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class LiveRoleCreate extends Component
{
    public ?Role $role = null;
    public $selectedRolePermissions = [];
    public $showRoleCreateForm = false;

    protected $listeners = ['createRole'];

    protected $rules = [
        'role.name' => 'required|string|unique:roles,name',
    ];

    public function saveRole()
    {
        $this->validate();

        $this->role->save();

        if ($this->selectedRolePermissions) {
            $this->role->syncPermissions($this->selectedRolePermissions);
        }

        $this->emit('roleCreated');
        $this->closeShowRoleCreateForm();
    }


    public function closeShowRoleCreateForm()
    {
        $this->showRoleCreateForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function updatedShowRoleCreateForm()
    {
        $this->resetValidation();
        $this->reset();
    }

    public function createRole()
    {
        $this->role = new Role();
        $this->showRoleCreateForm = true;
    }

    public function render()
    {
        $permissionGroup = null;

        if ($this->role) {
            $permissionGroup = Permission::all()->groupBy('group_name');
        }

        return view('livewire.live-role-create', [
            'permissionGroups' => $permissionGroup
        ]);
    }
}
