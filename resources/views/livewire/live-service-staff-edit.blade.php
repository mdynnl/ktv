<x-page-layout>
    <div class="max-w-xl">
        <form wire:submit.prevent="updateUser" class="space-y-8 divide-y divide-gray-200">
            <div class="space-y-8 divide-y divide-gray-200">
                <div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Service Staff</h3>
                        <p class="mt-1 text-sm text-gray-500">Fields marked with an * are required fields.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
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
                                    <img class="h-80 w-52 object-cover rounded-md"
                                         src="{{ $new_full_size_image->temporaryUrl() }}"
                                         alt="Current profile photo" />
                                </x-slot>
                            @elseif($full_size_image)
                                <x-slot name="preview">
                                    <img class="h-80 w-52 object-cover rounded-md"
                                         src="{!! $serviceStaff->getFullSizeImage !!}"
                                         alt="Current profile photo" />
                                </x-slot>
                            @endif
                        </x-form-file-input-comp>

                        <x-form-input-comp class="col-span-3" wire:model.defer="name_on_nrc" label="Name On Nrc*"
                                           for="name_on_nrc"
                                           type="text" />

                        <x-form-input-comp class="col-span-3" wire:model.defer="nick_name" label="Nick Name" for="user.nick_name"
                                           type="text" />

                        <x-form-input-comp class="sm:col-span-3" wire:model.defer="nrc" label="Nrc No" for="nrc"
                                           type="text" />


                        <x-form-input-comp class="sm:col-span-3" wire:model.defer="phone" label="Phone" for="phone"
                                           type="text" />

                        <div class="col-span-6">
                            <x-inline-checkbox-with-label wire:model.defer="isActive" :isDisabled="false" for="isActive" label="Active Status"
                                                          value="1" />
                        </div>

                        <x-form-textarea-comp class="sm:col-span-6" wire:model.defer="address" label="Address" for="address"
                                              rows="3"
                                              type="text" />


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
                       href="{{ route('service-staff.index') }}"
                       type="button"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Cancel
                    </a>
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-page-layout>
