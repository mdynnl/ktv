<div
     x-data="{
         show: @entangle('showRoomTransferForm'),
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
         message = '';
         success = false;
     })"
     @keydown.window.escape="show = false"
     @success-message.window="setSuccessMessage($event.detail.message)"
     @unsuccess-message.window="setErrorMessage($event.detail.message)"
     class="relative z-[1010]"
     aria-labelledby="modal-title" role="dialog"
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
            @isset($inhouse)
                <div
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-5xl">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div class="flex space-x-4 items-baseline">
                                <h1 class="text-2xl font-semibold leading-none">Room Transfer</h1>
                                <span class="leading-none">In House ID: {{ $inhouse->id }}</span>
                                @isset($inhouse->reservation_id)
                                    <span class="leading-none">Rsvn ID: {{ $inhouse->reservation_id }}</span>
                                @endisset
                            </div>

                            {{-- <div class="font-medium text-base">
                                <span>{{ "Room: $room->room_no " }}</span><span>{{ $room->type->room_type_name }}</span>
                            </div> --}}
                        </div>



                        <form wire:submit.prevent="saveRoomTransfer" class="space-y-4">
                            {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 px-6"> --}}
                            <div class="px-6">
                                <div class="space-y-8 sm:space-y-5">
                                    <div class="space-y-6 sm:space-y-1">
                                        <div class="mt-6 grid gap-y-6 gap-x-4 sm:grid-cols-6">

                                            <x-form-disabled-comp class="col-span-3" wire:model="inhouse.room.room_no"
                                                                  label="From Room No"
                                                                  for="inhouse.room.room_no"
                                                                  type="text" />

                                            <div class="col-span-3 flex items-end space-x-3 pb-2">
                                                <span class="text-gray-500">Room Type</span>
                                                <span class="font-semibold text-base">{{ $fromRoom->type->room_type_name }}</span>
                                            </div>

                                            <div class="col-span-3">
                                                <label for="room_no" class="block text-sm font-medium text-gray-700">
                                                    To Room No*
                                                </label>
                                                <div class="mt-1">
                                                    <select wire:model="roomTransfer.to_room_no" id="room_no" name="room_no"
                                                            class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md">
                                                        <option value=""></option>
                                                        @foreach ($rooms as $option)
                                                            <option value="{{ $option->room_no }}">
                                                                {{ $option->room_no }} - {{ $option->type->room_type_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-span-3 flex items-end space-x-3 pb-2">
                                                <span class="text-gray-500">Room Type</span>
                                                @isset($toRoom)
                                                    <span class="font-semibold text-base">{{ $toRoom->type->room_type_name }}</span>
                                                @endisset
                                            </div>


                                            <x-form-disabled-comp class="col-span-2" wire:model="currencyCode"
                                                                  label="Currency"
                                                                  for="currencyCode"
                                                                  type="text" />

                                            <x-form-disabled-comp class="col-span-2" wire:model="roomTransfer.from_room_rate"
                                                                  label="Current Room Rate"
                                                                  for="roomTransfer.from_room_rate"
                                                                  type="text" />

                                            <x-form-input-comp class="col-span-2" wire:model="roomTransfer.to_room_rate"
                                                               label="New Room Rate*"
                                                               for="roomTransfer.to_room_rate"
                                                               type="text" />

                                            <x-form-textarea-comp class="col-span-6" wire:model="roomTransfer.remark"
                                                                  label="Remark" for="roomTransfer.remark" rows="3" />

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

                            <div class="py-3 bg-gray-200 px-6">
                                <div class="flex justify-between items-center bg-gray-200">
                                    <div class="max-w-[208px] text-sm leading-tight">
                                        <span x-text="message"
                                              :class="success ? 'text-primary font-semibold' : 'text-red-400 font-semibold'"></span>
                                    </div>
                                    <div>
                                        <button wire:click="closeRoomTransferForm" type="button"
                                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Cancel</button>
                                        <button type="submit"
                                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
