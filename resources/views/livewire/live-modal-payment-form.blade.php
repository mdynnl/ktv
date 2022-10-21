<div
     x-data="{
         show: @entangle('showModalPaymentForm'),
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
            @isset($inhouse_id)
                <div
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-xl w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div class="flex space-x-4 items-baseline">
                                <h1 class="text-2xl font-semibold leading-none">Payment</h1>
                                {{-- <span class="leading-none">Inhouse Id: {{ $inhouse->id }}</span> --}}
                                <span class="leading-none">Room No: {{ $room_no }}</span>
                            </div>
                        </div>

                        <div class="m-6">
                            <div class="border overflow-hidden overflow-x-auto relative rounded-md shadow-md">
                                <table class="min-w-full border-separate " style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                        <tr class="divide-x">
                                            <x-th-slim>Amount</x-th-slim>
                                            <x-th-slim>Payment</x-th-slim>
                                            <x-th-slim>Remark</x-th-slim>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        <tr class="divide-x">
                                            <x-td-slim>{{ number_format($total, 0, '.', ',') }}</x-td-slim>

                                            <x-td-slim>
                                                <select wire:model="checkout_payment_type_id"
                                                        class="mt-1 block w-full rounded-md border-gray-300 py-1 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                    @foreach ($checkoutPaymentTypes as $paymentType)
                                                        <option value="{{ $paymentType->id }}">
                                                            {{ $paymentType->checkout_payment_type_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </x-td-slim>
                                            <x-td-slim>
                                                <input type="text" wire:model.lazy="remark" class="p-0 border-transparent"
                                                       placeholder="Remark...">
                                            </x-td-slim>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="py-3 bg-gray-200 px-6">
                            <div class="flex justify-end items-center bg-gray-200">
                                <div>
                                    <button @click="show = false" type="button"
                                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        Close
                                    </button>
                                    <button type="button" wire:click="saveCheckOutPayment"
                                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
