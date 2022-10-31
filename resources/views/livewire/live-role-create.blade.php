<div x-data="{ show: @entangle('showRoleCreateForm') }"
     @keydown.window.escape="show = false" class="relative z-[1000]" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">
    <div
         x-show="show"
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div
         x-show="show"
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed z-50 inset-0 overflow-y-auto">
        <div
             class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            @isset($role)
                <div
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 max-w-4xl w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div>
                                <h1 class="text-2xl font-semibold">Create a Role</h1>
                            </div>
                        </div>
                        <form wire:submit.prevent="saveRole" class="space-y-4">
                            <div class="grid grid-cols-1 gap-x-6 px-6">
                                <div class="space-y-8 sm:space-y-5">
                                    <div class="space-y-6 sm:space-y-1">
                                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                            <x-form-input-comp class="col-span-3" wire:model.defer="role.name"
                                                               label="Role Name*"
                                                               for="role.name"
                                                               type="text" />

                                            <div class="col-span-6">
                                                <header class="font-medium text-gray-700">Assign Permissions to Role</header>

                                                <div class="bg-white grid grid-cols-4 gap-10 mt-3">
                                                    @foreach ($permissionGroups as $key => $permissions)
                                                        <div class="col-span-1">
                                                            <header>{{ ucwords(Str::replace('_', ' ', $key)) }}</header>
                                                            <ul class="mt-1">
                                                                @foreach ($permissions as $permission)
                                                                    <li class="mb-1"
                                                                        wire:key="{{ $permission->id . '-' . $permission->permissionName }}">
                                                                        <x-inline-checkbox-with-label wire:model.defer="selectedRolePermissions"
                                                                                                      value="{{ $permission->id }}"
                                                                                                      label="{{ $permission->permissionName }}"
                                                                                                      for="selectedRolePermissions"
                                                                                                      isDisabled="{{ false }}" />
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="py-3 bg-gray-200 px-6">
                                <div class="flex justify-end bg-gray-200">
                                    <button @click="show = false" type="button"
                                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                                    <button type="submit"
                                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
