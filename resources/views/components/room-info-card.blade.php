<div
     x-data="{
         showActions: false,
         closeActions() {
             this.showActions = false;
         },
     
         handleClick(status, id, canAdd, canEdit) {
     
             if (status == 0) {
                 if (canAdd) {
                     $wire.emit('createWalkIn', id)
                 }
             } else {
                 if (canEdit) {
                     $wire.emit('editInhouse', id)
                 }
             }
         }
     }"
     {{-- @click="showActions = true" --}}
     @click="handleClick('{{ $room->status }}', '{{ $room->status == 0 ? $room->room_id : $room->inhouse_id }}', '{{ auth()->user()->can('add inhouse') }}', '{{ auth()->user()->can('edit inhouse') }}')"
     class="flex-shrink-0 max-w-[190px] relative w-full">
    <div
         class="cursor-pointer border min-h-[190px] max-w-[190px] w-full shadow-md rounded-md overflow-hidden flex flex-col relative">

        <div @class([
            'px-4 flex flex-col text-primary flex-1',
            'bg-arrival' => $room->checkout_payment_status,
            'bg-departure' =>
                !$room->checkout_payment_status &&
                ($room->status == 1 && $room->remaining > 1),
            'bg-red-400' =>
                !$room->checkout_payment_status &&
                ($room->status == 1 && $room->remaining < 1),
            'bg-occupy' => !$room->checkout_payment_status && $room->status == 2,
            'bg-vacant' => !$room->checkout_payment_status && $room->status == 0,
        ]) class="">
            <div class="py-3">
                <p class="font-medium text-lg">{{ "Room: $room->room_no" }}</p>
                @if ($room->status != 0)
                    <p class="font-semibold text-sm">Sessions: {{ number_format($room->total_minute / 60, 1) }}</p>
                @endif
            </div>
            <div class="py-3 text-lg font-semibold flex-1 flex items-center">
                @switch($room->status)
                    @case(1)
                        <h1>Departure</h1>
                    @break

                    @case(2)
                        <h1>Occupy</h1>
                    @break

                    @default
                        <h1>Vacant</h1>
                @endswitch
            </div>
        </div>
        <footer class="bg-primary h-12 text-white px-4 flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-semibold text-sm">{{ $room->remaining < 1 ? 0 : $room->remaining }} Min Left</p>
        </footer>
    </div>

    {{-- <div
         x-show="showActions"
         @click.outside="showActions = false"
         x-cloak
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute bg-white divide-gray-100 divide-y focus:outline-none origin-top-left ring-1 ring-black ring-opacity-5 rounded-md shadow-lg top-0 translate-x-1/3 mt-16 w-56 z-[5]"
         role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">

        @switch($room->status)
            @case(0)
                <div class="py-1" role="none">
                    <x-alpine-wire-emit-action-button event="createWalkIn"
                                                      actionId="{{ $room->room_id }}"
                                                      isDisabled="{{ false }}"
                                                      label="Check In" tabindex="-1" />
                </div>
            @break

            @default
                <div class="py-1" role="none">
                    <x-alpine-wire-emit-action-button event="editInhouse"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status === 1 : false }}"
                                                      label="Edit Inhouse" tabindex="-1" />

                    <x-alpine-wire-emit-action-button event="createRoomTransfer"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status === 1 : false }}"
                                                      label="Room Transfer" tabindex="-1" />

                    <x-alpine-wire-emit-action-button event="createOrder"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status === 1 : false }}"
                                                      label="Food Order" tabindex="-1" />

                    <x-alpine-wire-emit-action-button event="viewTransactions"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status === 1 : false }}"
                                                      label="Add Transaction" tabindex="-1" />

                    <x-alpine-wire-emit-action-button event="makePayment"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status === 1 : false }}"
                                                      label="Payment" tabindex="-1" />


                    <x-alpine-wire-emit-action-button event="checkoutRoom"
                                                      actionId="{{ $room->inhouse_id }}"
                                                      isDisabled="{{ isset($room->checkout_payment_status) ? $room->checkout_payment_status != 1 : true }}"
                                                      label="Check Out" tabindex="-1" />
                </div>
        @endswitch
    </div> --}}
</div>
