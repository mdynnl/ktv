<div
     x-data="{
         show: @entangle('showViewInvoiceModal'),
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
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-5xl w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div class="flex space-x-4 items-baseline">
                                <h1 class="text-2xl font-semibold leading-none">Invoice</h1>
                                {{-- <span class="leading-none">Inhouse Id: {{ $inhouse->id }}</span> --}}
                                <span class="leading-none">Room No: {{ $room_no }}</span>
                            </div>
                        </div>

                        <div class="m-6">

                            <div class="my-4 flex items-center justify-between">
                                {{-- <div class="flex-1 flex items-center justify-between">
                                    <fieldset>
                                        <legend class="sr-only">Invoice Payment Folio Filters</legend>
                                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6">
                                            <x-inline-checkbox-with-label wire:key="department-fo" wire:model="departments" label="Room Amount"
                                                                          isDisabled="{{ false }}"
                                                                          value="FO" for="room_amount" />
                                            <x-inline-checkbox-with-label wire:key="department-hk" wire:model="departments" label="HK Amount"
                                                                          isDisabled="{{ false }}"
                                                                          value="HK" for="hk_amount" />
                                        </div>
                                    </fieldset>

                                    <fieldset class="mr-8">
                                        <legend class="sr-only">Print Selection</legend>
                                        <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6">
                                            <x-inline-checkbox-with-label wire:key="print-selection" wire:model="printSelected"
                                                                          isDisabled="{{ empty($selectedKeys) }}"
                                                                          label="Print Selected"
                                                                          value="true" for="printSelected" />
                                        </div>
                                    </fieldset>
                                </div> --}}


                                <div class="flex space-x-3">
                                    <x-custom-wire-box-button wire:click="printInvoice"
                                                              label="Invoice"
                                                              isDisabled="{{ !$payments->count() > 0 }}" />
                                    {{-- <x-custom-wire-box-button wire:click="$emit('makePayments', {{ $inhouse_id }})"
                                                              label="Payment"
                                                              isDisabled="{{ !$payments->count() > 0 || $checkout_payment_done }}" /> --}}
                                    {{-- <x-custom-wire-box-button wire:click="printFolio"
                                                              label="Folio"
                                                              isDisabled="{{ !$payments->count() > 0 || !$inhouse->checkout_payment_done }}" /> --}}
                                </div>
                            </div>




                            <div class="border h-[408px] overflow-y-auto overflow-hidden relative rounded-md shadow-md">
                                <table class="min-w-full border-separate " style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                        <tr class="divide-x">
                                            {{-- <x-th-slim></x-th-slim> --}}
                                            {{-- <x-th-slim>Date</x-th-slim> --}}
                                            <x-th-slim>Description</x-th-slim>
                                            <x-th-slim>Reference</x-th-slim>
                                            <x-th-slim-with-align align="center" width="100px">Price</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center">Qty</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Amount</x-th-slim-with-align>
                                            {{-- <x-th-slim>Amount (USD)</x-th-slim> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @if ($payments->count() > 0)
                                            @foreach ($payments as $key => $payment)
                                                <tr class="divide-x" wire:key="{{ $key }}">
                                                    <x-td-slim>{{ ucwords($payment->description) }}</x-td-slim>
                                                    <x-td-slim>{{ ucwords($payment->reference) }}</x-td-slim>
                                                    <x-td-slim-with-align align="right">
                                                        {{ $payment->price != 0 ? number_format($payment->price, 0, '.', ',') : '' }}
                                                    </x-td-slim-with-align>
                                                    <x-td-slim-with-align align="center">{{ $payment->qty }}</x-td-slim-with-align>
                                                    <x-td-slim-with-align align="right">
                                                        {{ number_format($payment->amount, 0, '.', ',') }}
                                                    </x-td-slim-with-align>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="py-6 text-center bg-gray-100">
                                                    No items to show.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <form wire:submit.prevent="updateTax">
                                    <div class="grid grid-cols-6 gap-x-3">
                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Sub Total</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($sub_total, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Commercial Tax %</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($commercial_tax, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Commercial Tax Amt</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($commercial_tax_amount, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Service Tax %</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($service_tax, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Service Tax Amt</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($service_tax_amount, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Total</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($total, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="py-3 bg-gray-200 px-6">
                            <div class="flex justify-between items-center bg-gray-200">
                                <div></div>
                                <div>
                                    <button @click="show = false" type="button"
                                            class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        Close
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
