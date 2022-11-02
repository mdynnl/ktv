<x-modal wire:model="showChangePasswordForm" size="sm">
    @isset($showChangePasswordForm)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Change Password
            </h1>
        </x-slot>

        <div class="text-gray-700">
            <div class="mt-4 grid grid-cols-1 space-y-4">
                <x-form-password-input-comp class="sm:col-span-2" wire:model.defer="current_password" label="Current Password*"
                                            for="current_password"
                                            type="text" />

                <x-form-password-input-comp class="sm:col-span-2" wire:model.defer="password" label="New Password*"
                                            for="password"
                                            type="password" />

                <x-form-password-input-comp class="sm:col-span-2" wire:model.defer="password_confirmation" label="Confirm New Password*"
                                            for="password_confirmation"
                                            type="text" />
            </div>

            {{-- <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div> --}}

            <!-- Confirm Password -->
            {{-- <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                              type="password"
                              name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div> --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <x-slot name="modalAction">
            <button wire:click="update"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Update
            </button>
        </x-slot>
    @endisset
</x-modal>
