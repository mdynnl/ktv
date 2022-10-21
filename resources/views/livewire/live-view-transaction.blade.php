<div
     x-data="{
         show: @entangle('showTransactionsView'),
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
                     class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl w-full">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg ">

                        <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                            <div class="flex space-x-4 items-baseline">
                                <h1 class="text-2xl font-semibold leading-none">Adjustments</h1>
                                <span class="leading-none">Room No: {{ $inhouse->room_no }}</span>
                            </div>
                        </div>

                        <div class="m-6">
                            <div class="border overflow-hidden relative rounded-md shadow-md">
                                <table class="min-w-full border-separate " style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                        <tr class="divide-x">
                                            <x-th-slim>Transaction</x-th-slim>
                                            {{-- <x-th-slim>Currency</x-th-slim> --}}
                                            <x-th-slim>Amount</x-th-slim>
                                            {{-- <x-th-slim>Payment</x-th-slim> --}}
                                            <x-th-slim class="w-96">Remark</x-th-slim>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @if ($inhouse->incomeTransactions->count() > 0)
                                            @foreach ($inhouse->incomeTransactions as $transaction)
                                                <tr wire:key="{{ $transaction->id }}" class="divide-x">
                                                    <x-td-slim>{{ $transaction->transaction->transaction_name }}</x-td-slim>
                                                    {{-- <x-td-slim>{{ $transaction->currency_code }}</x-td-slim> --}}
                                                    <x-td-slim>{{ $transaction->amount }}</x-td-slim>
                                                    {{-- <x-td-slim>{{ $transaction->payment }}</x-td-slim> --}}
                                                    <x-td-slim>{{ $transaction->remark }}</x-td-slim>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="py-6 text-center bg-gray-100">
                                                    No transactions to show.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="py-3 bg-gray-200 px-6">
                            <div class="flex justify-between items-center bg-gray-200">
                                <div>
                                    <button type="button"
                                            wire:click="$emit('addTransactions', '{{ $inhouse->id }}')"
                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-primary"
                                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                                        Make Adjustments
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path
                                                  d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                        </svg>
                                    </button>
                                </div>
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
