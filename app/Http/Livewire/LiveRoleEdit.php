<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class LiveRoleEdit extends Component
{
    public ?Role $role = null;
    public $selectedRolePermissions = [];
    public $showRoleEditForm = false;

    protected $listeners = ['editRole'];

    protected function rules()
    {
        return [
        'role.name' => 'required|string|unique:roles,name,' . $this->role->id,
        ];
    }

    public function updateRole()
    {
        $this->validate();

        $this->role->update();

        if ($this->selectedRolePermissions) {
            $this->role->syncPermissions($this->selectedRolePermissions);
        }

        $this->emit('roleUpdated');
        $this->closeShowRoleEditForm();
    }

    public function closeShowRoleEditForm()
    {
        $this->showRoleEditForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function updatedShowRoleEditForm()
    {
        $this->resetValidation();
        $this->reset();
    }

    public function editRole(Role $role)
    {
        $this->role = $role;
        $this->selectedRolePermissions = $role->permissions->pluck('id');
        $this->showRoleEditForm = true;
    }

    public function render()
    {
        $permissionGroup = null;


        if ($this->role) {
            $permissionGroup = Permission::all()->groupBy('group_name');
        }

        return view('livewire.live-role-edit', [
            'permissionGroups' => $permissionGroup
        ]);
    }
}
