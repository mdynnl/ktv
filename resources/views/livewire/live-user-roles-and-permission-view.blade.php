<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-users-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex space-x-5 items-center">
            <div class="flex items-center space-x-3">
                <label class="flex-shrink-0">User Roles</label>
                <select wire:model="selectedRole"
                        class="block w-full focus:border-primary focus:ring-primary sm:text-sm rounded-md border-gray-300">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button"
                    wire:click="$emit('editRole', {{ $selectedRole }})"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path
                          d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                    <path
                          d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                </svg>
                <span>Edit Role</span>
            </button>

            <button type="button"
                    wire:click="$emit('createRole')"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path
                          d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                <span>Add New Role</span>
            </button>
        </div>
    </x-content-header-section>

    <div class="max-w-5xl">
        <div class="bg-white py-6 grid grid-cols-4 gap-8">
            @foreach ($permissionGroups as $key => $permissions)
                <div class="col-span-1">
                    <header>{{ ucwords(Str::replace('_', ' ', $key)) }}</header>
                    <ul class="mt-1">
                        @foreach ($permissions as $permission)
                            <li class="mb-1" wire:key="{{ $permission->id . '-' . $permission->permissionName }}">
                                <x-inline-disabled-checkbox-with-label wire:model.defer="selectedRolePermissions"
                                                                       value="{{ $permission->id }}"
                                                                       label="{{ $permission->permissionName }}"
                                                                       for="selectedRolePermissions" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <livewire:live-role-create />
    <livewire:live-role-edit />
</x-page-layout>
