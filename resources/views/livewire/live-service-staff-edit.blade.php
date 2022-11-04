<x-modal wire:model="showServiceStaffEditForm" size="md2">
    @if ($serviceStaff)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit {{ $serviceStaff->nick_name }}
            </h1>
        </x-slot>

        <form wire:submit.prevent="update" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="col-span-3 grid grid-cols-1 gap-y-3 gap-x-4 sm:grid-cols-6">
                                <x-form-file-input-comp class="col-span-6" wire:model="new_profile_image" label="Profile Image"
                                                        for="new_profile_image">
                                    @if ($new_profile_image)
                                        <x-slot name="preview">
                                            <img class="h-16 w-16 object-cover rounded-full"
                                                 src="{{ $new_profile_image->temporaryUrl() }}"
                                                 alt="Current profile photo" />
                                        </x-slot>
                                    @elseif($profile_image)
                                        <x-slot name="preview">
                                            <img class="h-16 w-16 object-cover rounded-full"
                                                 src="{!! $serviceStaff->getImage !!}"
                                                 alt="Current profile photo" />
                                        </x-slot>
                                    @endif
                                </x-form-file-input-comp>

                                <x-form-file-input-comp class="col-span-6" wire:model="new_full_size_image" label="Full Size Image"
                                                        for="full_size_image">
                                    @if ($new_full_size_image)
                                        <x-slot name="preview">
                                            <img class="h-[12.5rem] object-cover rounded-md"
                                                 src="{{ $new_full_size_image->temporaryUrl() }}"
                                                 alt="Current profile photo" />
                                        </x-slot>
                                    @elseif($full_size_image)
                                        <x-slot name="preview">
                                            <img class="h-[12.5rem] object-cover rounded-md"
                                                 src="{!! $serviceStaff->getFullSizeImage !!}"
                                                 alt="Current profile photo" />
                                        </x-slot>
                                    @endif
                                </x-form-file-input-comp>
                            </div>

                            <div class="col-span-3 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <x-form-input-comp class="col-span-6" wire:model.defer="name_on_nrc" label="Name*"
                                                   for="name_on_nrc"
                                                   type="text" />

                                <x-form-input-comp class="col-span-6" wire:model.defer="nick_name" label="Nick Name*" for="user.nick_name"
                                                   type="text" />

                                <x-form-input-comp class="sm:col-span-6" wire:model.defer="nrc" label="NRC No" for="nrc"
                                                   type="text" />

                                <x-form-datepicker-comp class="sm:col-span-6" wire:model.defer="dob" label="Date of Birth"
                                                        for="dob" />


                                <x-form-input-comp class="sm:col-span-6" wire:model.defer="phone" label="Phone" for="phone"
                                                   type="text" />
                            </div>

                            <div class="col-span-6">
                                <x-inline-checkbox-with-label wire:model.defer="isActive" :isDisabled="false" for="isActive"
                                                              label="Active Status"
                                                              value="1" />
                            </div>

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
            <button type="submit" wire:click="update"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Update
            </button>
        </x-slot>
    @endif
</x-modal>
