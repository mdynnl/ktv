<x-modal wire:model="showInhouseSearchAddServiceStaff" size="md2">
    @if ($showInhouseSearchAddServiceStaff)
        <x-slot name="modalHeader">
            <div>
                <h1 class="text-2xl font-semibold">Search & Add Service Staff</h1>
            </div>

            <div>
                @if ($inhouseId)
                    {{ now()->format('g:i A') }}
                @endif
            </div>
        </x-slot>

        <div class="h-full">
            <div class="flex flex-col h-full">
                <div class="px-6 flex-1">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mb-3">
                        <x-form-input-comp class="col-span-4" wire:model="search" label="Search"
                                           for="search-service-staffs"
                                           type="text" />

                        <div class="col-span-2 flex flex-col">
                            <h1 class="block text-sm font-medium text-gray-700">Sessions</h1>
                            <div class="flex-1 flex items-center mt-1 space-x-2">
                                <span
                                      class="border border-gray-300 flex-1  h-full inline-flex items-center px-2.5 rounded-md shadow-sm sm:text-sm w-full">{{ $session_hours }}</span>
                                <button type="button"
                                        wire:click="changeSessionHours('{{ false }}')"
                                        class="disabled:bg-gray-300 enabled:bg-primary h-full px-2 rounded-md text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                              d="M3 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button type="button" wire:click="changeSessionHours()"
                                        class="disabled:bg-gray-300 enabled:bg-primary h-full px-2 rounded-md text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" class="w-5 h-5">
                                        <path
                                              d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>




                        <x-form-onlydate-picker-comp wire:key="1-d" class="sm:col-span-3"
                                                     isDisabled="{{ false }}"
                                                     wire:model.lazy="arrivalDate"
                                                     label="Checkin Date"
                                                     for="arrivalDate" />

                        <x-form-html-timepicker-comp wire:key="1-t" class="sm:col-span-3"
                                                     isDisabled="{{ false }}"
                                                     wire:model.lazy="arrivalTime"
                                                     label="Checkin Time"
                                                     for="arrivalTime" />



                        <x-form-disabled-comp class="col-span-3" wire:model="departureDate" label="Checkout Date"
                                              for="departureDate"
                                              type="text" />
                        <x-form-disabled-comp class="col-span-3" wire:model="departureTime" label="Checkout Time"
                                              for="departureTime"
                                              type="text" />
                    </div>


                    <div class="h-[400px] border overflow-y-scroll relative rounded-xl shadow-md mt-6">
                        <table class="min-w-full border-separate " style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr class="divide-x">
                                    <x-th-slim>Service Staffs</x-th-slim>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($staffs as $staff)
                                    <tr
                                        wire:key="{{ $staff->id . '-' . $staff->nick_name }}"
                                        class="divide-x">
                                        <x-td-slim-checkbox>
                                            <x-inline-checkbox-with-label-image
                                                                                for="{{ $staff->id }}"
                                                                                :isDisabled="false"
                                                                                wire:model="selectedStaff"
                                                                                image="{!! $staff->getImage !!}"
                                                                                label="{{ $staff->nick_name }}"
                                                                                value="{{ $staff->id }}" />
                                        </x-td-slim-checkbox>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="modalLeftAction">
            <div x-data="{
                message: '',
                success: false,
                setSuccessMessage(message) {
                    this.success = true
                    this.message = message
                },
                setErrorMessage(message) {
                    this.success = false
                    this.message = message
                },
            }"

                 x-init="$watch('show', () => {
                     message = ' ';
                     success = false;
                 })"
                 @success-inhouse-service-message.window="setSuccessMessage($event.detail.message)"
                 @unsuccess-inhouse-service-message.window="setErrorMessage($event.detail.message)"
                 class="h-full inline-flex items-center px-3">
                <p><span x-text="message"
                          :class="success ? 'text-primary font-semibold' : 'text-red-400 font-semibold'"></span></p>
            </div>
        </x-slot>

        <x-slot name="modalAction">
            <button wire:click="addServiceStaffs" type="button"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Add
                Selected Staff</button>
        </x-slot>
    @endif
</x-modal>
