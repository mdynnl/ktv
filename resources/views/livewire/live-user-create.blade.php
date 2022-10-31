<x-page-layout>
    <div class="max-w-4xl">
        <form wire:submit.prevent="createUser" class="space-y-8 divide-y divide-gray-200">
            <div class="space-y-8 divide-y divide-gray-200">
                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Add a User</h3>
                        <p class="mt-1 text-sm text-gray-500">Fields marked with an * are required fields.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- <x-form-file-input-comp class="col-span-6" wire:model="image" label="User Avatar" for="image">
                            @if ($image)
                                <x-slot name="preview">
                                    <img class="h-16 w-16 object-cover rounded-full"
                                         src="{{ $image->temporaryUrl() }}"
                                         alt="Current profile photo" />
                                </x-slot>
                            @endif
                        </x-form-file-input-comp> --}}


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
                        <x-form-input-with-description-comp class="sm:col-span-2" wire:model.defer="password" label="Password*"
                                                            for="password"
                                                            description="Passwords must minimum 8 characters long."
                                                            type="text" />

                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="nrc" label="Nrc No" for="nrc"
                                           type="text" />
                        <x-form-datepicker-comp class="sm:col-span-2" wire:model.defer="dob" label="Date of Birth"
                                                for="dob" />

                        <x-form-gender-select-comp class="col-span-2" wire:model.defer="gender" label="Gender"
                                                   for="gender" />
                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="email" label="Email" for="email"
                                           type="email" />


                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="phone" label="Phone" for="phone"
                                           type="text" />
                        <div class="col-span-2"></div>

                        <x-form-textarea-comp class="sm:col-span-6" wire:model.defer="address" label="Address" for="address"
                                              rows="3"
                                              type="text" />

                        {{-- <x-form-select-comp class="col-span-1" wire:model.defer="user.honorific_id" :options="$honorifics"
                                            label="Honorific"
                                            optionValue="id"
                                            optionDisplay="honorific_name"
                                            for="user.honorific_id" />

                        <x-form-input-comp class="col-span-3" wire:model.defer="user.first_name" label="First Name*"
                                           for="user.first_name"
                                           type="text" />

                        <x-form-input-comp class="col-span-2" wire:model.defer="user.last_name" label="Last Name" for="user.last_name"
                                           type="text" />

                        <x-form-select-comp class="col-span-2" wire:model.defer="role" :options="$roles"
                                            label="Role*"
                                            optionValue="id"
                                            optionDisplay="name"
                                            for="role" />
                        <x-form-input-with-description-comp class="sm:col-span-2" wire:model.defer="user.username" label="Username*"
                                                            for="user.username"
                                                            description="Username must be unique and can be used to login."
                                                            type="text" />
                        <x-form-input-with-description-comp class="sm:col-span-2" wire:model.defer="user.password" label="Password*"
                                                            for="user.password"
                                                            description="Passwords must minimum 8 characters long."
                                                            type="text" />

                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="user.nrc" label="Nrc No" for="user.nrc"
                                           type="text" />
                        <x-form-datepicker-comp class="sm:col-span-2" wire:model.defer="user.dob" label="Date of Birth"
                                                for="user.dob" />

                        <x-form-gender-select-comp class="col-span-2" wire:model.defer="user.gender" label="Gender"
                                                   for="user.gender" />
                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="user.email" label="Email" for="user.email"
                                           type="email" />


                        <x-form-input-comp class="sm:col-span-2" wire:model.defer="user.phone" label="Phone" for="user.phone"
                                           type="text" />
                        <div class="col-span-2"></div>

                        <x-form-textarea-comp class="sm:col-span-6" wire:model.defer="user.address" label="Address" for="user.address"
                                              rows="3"
                                              type="text" /> --}}

                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="pt-5">
                <div class="flex justify-end">
                    <a
                       href="{{ route('users') }}"
                       type="button"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancel
                    </a>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-page-layout>
