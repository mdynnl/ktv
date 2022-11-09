<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveUserRolesAndPermissionView extends Component
{
    use AuthorizesRequests;
    public $roles;
    public $selectedRole;
    public $selectedRolePermissions = [];

    protected $listeners = ['roleCreated' => '$refresh', 'roleUpdated' => '$refresh'];

    public function mount()
    {
        $this->authorize('view roles');
        $this->roles = Role::with('permissions')->get();
        $this->selectedRole = $this->roles->first()->id;
    }

    public function render()
    {
        $this->selectedRolePermissions = $this->roles->where('id', $this->selectedRole)->first()->permissions->pluck('id');
        return view('livewire.live-user-roles-and-permission-view', [
            'permissionGroups' => Permission::all()->groupBy('group_name')
        ]);
    }
}
