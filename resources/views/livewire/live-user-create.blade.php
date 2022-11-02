<x-modal wire:model="showUserCreateForm" size="md2">
    @if ($showUserCreateForm)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Add a User
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <x-form-input-comp class="col-span-4" wire:model.defer="name" label="Name*"
                                               for="user.name"
                                               type="text" />

                            <x-form-select-comp class="col-span-2" wire:model.defer="role" :options="$roles"
                                                label="Role*"
                                                optionValue="id"
                                                optionDisplay="name"
                                                for="role" />

                            <x-form-input-with-description-comp class="sm:col-span-2" wire:model.defer="username" label="Username*"
                                                                for="username"
                                                                description="Username must be unique and can be used to login."
                                                                type="text" />

                            <x-form-password-input-comp class="sm:col-span-2" wire:model.defer="password" label="Password*"
                                                        for="password"
                                                        description="Passwords must be minimum 8 characters long."
                                                        type="password" />

                            <x-form-input-comp class="sm:col-span-2" wire:model.defer="nrc" label="NRC No" for="nrc"
                                               type="text" />
                            <x-form-datepicker-comp class="sm:col-span-2" wire:model.defer="dob" label="Date of Birth"
                                                    for="dob" />

                            <x-form-gender-select-comp class="col-span-2" wire:model.defer="gender" label="Gender"
                                                       for="gender" />

                            <div class="col-span-2"></div>
                            <x-form-input-comp class="sm:col-span-2" wire:model.defer="email" label="Email" for="email"
                                               type="email" />

                            <x-form-input-comp class="sm:col-span-2" wire:model.defer="phone" label="Phone" for="phone"
                                               type="text" />
                            <div class="col-span-2"></div>

                            <x-form-textarea-comp class="sm:col-span-6" wire:model.defer="address" label="Address" for="address"
                                                  rows="3"
                                                  type="text" />

                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="modalAction">
            <button type="submit" wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create
            </button>
        </x-slot>
    @endif
</x-modal>
