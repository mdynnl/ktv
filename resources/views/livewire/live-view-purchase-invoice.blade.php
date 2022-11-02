<div
     x-data="{
         show: @entangle('showPurchaseInvoiceModal'),
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
            @isset($purchase)
                <div
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-5xl w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div class="flex space-x-4 items-baseline">
                                <h1 class="text-2xl font-semibold leading-none">Purchase Detail</h1>
                                <span class="leading-none">Reg No: {{ $purchase->id }}</span>
                                {{-- <span class="leading-none">Room No: {{ $room_no }}</span> --}}
                            </div>
                        </div>

                        <div class="m-6">

                            <div class="my-4 ">
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                    <x-display-info-comp class="col-span-1" label="Invoice No" displayValue="{{ $purchase->invoice_no }}" />

                                    <x-display-info-comp class="col-span-2" label="Invoice No"
                                                         displayValue="{{ $purchase->supplier->supplier_name }}" />

                                    <x-display-info-comp class="col-span-1" label="Purchase Date"
                                                         displayValue="{{ $purchase->purchase_date }}" />

                                    <x-display-info-comp class="col-span-1" label="Due Date"
                                                         displayValue="{{ $purchase->due_date }}" />

                                    <x-display-info-comp class="col-span-1" label="Payment Type"
                                                         displayValue="{{ $purchase->paymentType->payment_type_name }}" />
                                </div>
                            </div>




                            <div class="border h-[408px] overflow-y-auto overflow-hidden relative rounded-md shadow-md">
                                <table class="min-w-full border-separate " style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                        <tr class="divide-x">
                                            <x-th-slim-with-align align="left">Item</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Invoice Unit</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="150px">Price</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Qty</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Amount</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Recipe Unit</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center" width="100px">Recipe Qty</x-th-slim-with-align>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($purchaseDetails as $key => $pd)
                                            <tr class="divide-x" wire:key="{{ $key }}">
                                                <x-td-slim>{{ $pd->item->item_name }}</x-td-slim>
                                                <x-td-slim>{{ $pd->invoice_unit }}</x-td-slim>
                                                <x-td-centered-slim class="text-center">{{ number_format($pd->price, 0, '.', ',') }}
                                                </x-td-centered-slim>
                                                <x-td-centered-slim class="text-center">{{ $pd->qty }}</x-td-centered-slim>
                                                <x-td-centered-slim class="text-center">
                                                    {{ number_format($pd->qty * $pd->price, 0, '.', ',') }}</x-td-centered-slim>
                                                <x-td-centered-slim class="text-center">{{ $pd->item->recipe_unit }}</x-td-centered-slim>
                                                <x-td-centered-slim class="text-center">{{ $pd->recipe_qty }}</x-td-centered-slim>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <form wire:submit.prevent="updateTax">
                                    <div class="grid grid-cols-6 gap-x-3">
                                        <div class="col-span-2"></div>
                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Amount</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($purchase->amount, 0, '.', ',') }}</spav>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Discount</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($purchase->discount, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Tax</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($purchase->tax, 0, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-1">
                                            <label class="block text-sm font-medium text-gray-700">Total</label>
                                            <div class="mt-1">
                                                <div
                                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                                    <span>{{ number_format($purchase->total, 0, '.', ',') }}</span>
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
