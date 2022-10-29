<x-modal wire:model="showWalkInForm" size="lg">
    @isset($inhouse)
        <x-slot name="modalHeader">
            <div>
                <h1 class="text-2xl font-semibold">Check In</h1>
            </div>

            <div class="font-medium text-base">
                <span>{{ "Room: $room->room_no " }}</span><span>{{ $room->type->room_type_name }}</span>
            </div>
        </x-slot>

        <form wire:submit.prevent="checkIn" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-8">
                            <x-form-select-comp class="col-span-4" wire:model="inhouse.customer_id" :options="$customers" optionValue="id"
                                                optionDisplay="customer_name" label="Customer" for="inhouse.customer_id" />


                            <x-form-disabled-comp class="col-span-2" wire:model="inhouse.room_rate" label="Room Rate*"
                                                  for="inhouse.room_rate"
                                                  type="text" />

                            <div class="col-span-2 flex flex-col">
                                <h1 class="block text-sm font-medium text-gray-700">Sessions</h1>
                                <div class="flex-1 flex items-center mt-1 space-x-2">
                                    <span
                                          class="border border-gray-300 flex-1  h-full inline-flex items-center px-2.5 rounded-md shadow-sm sm:text-sm w-full">{{ $inhouse->session_hours }}</span>
                                    <button {{ $inhouse->session_hours <= 1 ? 'disabled' : '' }} type="button"
                                            wire:click="changeSessionHours('{{ false }}')"
                                            class="disabled:bg-gray-300 enabled:bg-primary h-full px-2 rounded-md text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button type="button" wire:click="changeSessionHours()"
                                            class="bg-primary h-full px-2 rounded-md text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                             fill="currentColor" class="w-5 h-5">
                                            <path
                                                  d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <x-form-onlydate-picker-comp wire:key="1-d" class="sm:col-span-2"
                                                         isDisabled="{{ false }}"
                                                         wire:model.lazy="arrivalDate"
                                                         label="Checkin Date"
                                                         for="inhouse.arrival" />

                            <x-form-html-timepicker-comp wire:key="1-t" class="sm:col-span-2"
                                                         :isDisabled="false"
                                                         wire:model.lazy="arrivalTime"
                                                         label="Checkin Time"
                                                         for="inhouse.arrival" />

                            <x-form-onlydate-picker-comp wire:key="2-d" class="sm:col-span-2"
                                                         :isDisabled="true"
                                                         wire:model="departureDate"
                                                         label="Checkout Date"
                                                         for="inhouse.departure" />

                            <x-form-html-timepicker-comp wire:key="2-t" class="sm:col-span-2"
                                                         wire:model="departureTime"
                                                         :isDisabled="true"
                                                         label="Checkout Time"
                                                         for="inhouse.departure" />




                            <div class="col-span-8">
                                <div class="h-60 border overflow-y-scroll relative rounded-md shadow-md">
                                    <table class="min-w-full border-separate " style="border-spacing: 0">
                                        <thead class="bg-gray-50">
                                            <tr class="divide-x">
                                                <x-th-slim>Staff Name</x-th-slim>
                                                <x-th-slim class="w-48">Check In</x-th-slim>
                                                {{-- <x-th-slim class="w-48">Check Out</x-th-slim> --}}
                                                <x-th-centered-slim class="w-20">Sessions</x-th-centered-slim>
                                                <x-th-slim class="w-20" align="right">Rate</x-th-slim>
                                                <x-th-slim class="w-20"></x-th-slim>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach ($staffs as $key => $staff)
                                                <tr
                                                    wire:key="{{ $staff['id'] . '-' . $staff['nick_name'] }}"
                                                    class="divide-x">
                                                    <x-td-slim>{{ $staff['nick_name'] }}</x-td-slim>
                                                    <x-td-slim>{{ $staff['arrival'] }}</x-td-slim>
                                                    <x-td-centered-slim class="text-center">{{ $staff['sessions'] }}</x-td-centered-slim>
                                                    <x-td-slim>{{ number_format($staff['service_staff_rate'], 0, '.', ',') }}</x-td-slim>
                                                    <x-td-slim-nopadding>
                                                        <button type="button" wire:click="removeStaff('{{ $key }}')"
                                                                class="ml-3 hover:bg-gray-200 p-1 rounded-md">
                                                            <svg class="h-5 text-gray-500 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd"
                                                                      d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                      clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        {{-- <button type="button"
                                                                wire:click="clickShowStaffTimeAdjustmentModal('{{ $key }}')"
                                                                class="ml-3 hover:bg-gray-200 p-1 rounded-md">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                                 class="h-5 text-gray-500 w-5">
                                                                <path
                                                                      d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                                <path
                                                                      d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                            </svg>
                                                        </button> --}}
                                                    </x-td-slim-nopadding>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
        </form>


        <x-slot name="modalLeftAction">

            <button type="button"
                    wire:click="$emit('searchAddStaff', 'checkIn')"
                    class="inline-flex items-center rounded-md border border-transparent enabled:bg-white disabled:bg-gray-300 disabled:text-gray-500 px-4 py-2 text-sm font-medium  shadow-sm focus:outline-none "
                    id="menu-button" aria-expanded="true" aria-haspopup="true">
                Service Staff
            </button>


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
                 @success-walkin-message.window="setSuccessMessage($event.detail.message)"
                 @unsuccess-walkin-message.window="setErrorMessage($event.detail.message)"
                 class="inline-flex px-3">
                <p><span x-text="message"
                          :class="success ? 'text-primary font-semibold' : 'text-red-400 font-semibold'"></span></p>
            </div>
        </x-slot>

        <x-slot name="modalAction">
            <button type="submit" wire:click="checkIn"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create
            </button>
        </x-slot>
    @endisset


    {{-- Change Staff Checkint Moda --}}
    <div wire:key="1-staff-modal">
        <div x-data="{
            showStaffTimeAdjustmentModal: @entangle('showStaffTimeAdjustmentModal')
        }" class="relative z-[1001]">
            <div
                 x-show="showStaffTimeAdjustmentModal"
                 x-cloak
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div x-show="showStaffTimeAdjustmentModal" x-cloak class="fixed flex inset-0 items-center justify-center z-10">
                <div @click.outside="showStaffTimeAdjustmentModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    <form wire:submit.prevent="updateStaffTimeChanges">

                        @if ($editingStaff)
                            <div class="flex-1 px-4 py-5 text-sm">
                                <div class="grid grid-cols-6 gap-x-4 gap-y-3">
                                    <div class="col-span-6 font-semibold text-base mb-3"><span class="text-gray-700">Staff Name:</span>
                                        {{ $editingStaffName }}</div>
                                    <x-form-onlydate-picker-comp wire:key="1-md" class="sm:col-span-3"
                                                                 wire:model.lazy="editingStaffArrivalDate"
                                                                 label="Checkin Date"
                                                                 for="editingStaffArrivalDate" />

                                    <x-form-html-timepicker-comp class="col-span-3" wire:model="editingStaffArrivalTime"
                                                                 for="editingStaffArrivalTime"
                                                                 :isDisabled="false"
                                                                 max="{{ $editingStaffMax }}"
                                                                 min="{{ $editingStaffMin }}"
                                                                 label="Checkin Time" />

                                    <div class="col-span-3 flex flex-col">
                                        <label for="editingStaffDepartureDate"
                                               class="block text-sm font-medium text-gray-700">Checkout Date</label>
                                        <div
                                             class="border border-gray-300 flex flex-1 focus:border-primary focus:ring-primary items-center mt-1 px-3 rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                            {{ $editingStaffDepartureDate }}
                                        </div>
                                    </div>

                                    <x-form-html-timepicker-comp class="col-span-3" wire:model="editingStaffDepartureTime"
                                                                 for="editingStaffDepartureTime"
                                                                 :isDisabled="true"
                                                                 max="{{ $editingStaffMax }}"
                                                                 min="{{ $editingStaffMin }}"
                                                                 label="Checkout Time" />

                                    <div class="col-span-6 flex flex-col h-[62px]">
                                        <h1 class="block text-sm font-medium text-gray-700">Sessions</h1>
                                        <div class="flex-1 flex items-center mt-1 space-x-2">
                                            <span
                                                  class="border border-gray-300 flex-1  h-full inline-flex items-center px-2.5 rounded-md shadow-sm sm:text-sm w-full">{{ $editingStaffSessionHours }}</span>
                                            <button {{ $editingStaffSessionHours <= 0.5 ? 'disabled' : '' }} type="button"
                                                    wire:click="changeStaffSessionHours('{{ false }}')"
                                                    class="disabled:bg-gray-300 enabled:bg-primary h-full px-2 rounded-md text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                     class="w-5 h-5">
                                                    <path fill-rule="evenodd"
                                                          d="M3 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z"
                                                          clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <button {{ $editingStaffSessionHours >= $inhouse->session_hours ? 'disabled' : '' }}
                                                    type="button" wire:click="changeStaffSessionHours()"
                                                    class="disabled:bg-gray-300 enabled:bg-primary h-full px-2 rounded-md text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" class="w-5 h-5">
                                                    <path
                                                          d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif

                        <div class="py-3 bg-gray-200 px-6">
                            <div class="flex justify-end space-x-3 bg-gray-200">
                                <button wire:click="$set('showStaffTimeAdjustmentModal', false)" type="button"
                                        class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                    Close
                                </button>
                                <button type="submit"
                                        class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-modal>
