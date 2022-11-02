<x-modal wire:model="showPurchaseCreateModal" size="xxl" cancelButtonLabel="Close">
    @if ($createPurchaseNow)
        <x-slot name="modalHeader">
            <div class="flex space-x-3 items-baseline">
                <h1 class="text-2xl font-semibold">Add a Purchase</h1>
                {{-- <span>Remains: <span class="font-semibold text-xl">{{ $remainingTime }}</span></span> --}}
                {{-- <span>Passed: {{ $sessionsPassed }}</span>
                <span>R: {{ $decimals }}</span> --}}
            </div>

            <div class="font-medium text-base">
                {{-- <span>{{ "Room: $room->room_no " }}</span><span>{{ $room->type->room_type_name }}</span> --}}
            </div>
        </x-slot>


        <div class="grid grid-cols-8 gap-x-6">
            <form wire:submit.prevent="create" class="col-span-8 space-y-4">
                <div class="grid grid-cols-1 gap-x-6">
                    <div class="space-y-8 sm:space-y-5">
                        <div class="space-y-6 sm:space-y-1">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <x-form-input-comp class="col-span-1" wire:model.defer="invoice_no" label="Invoice No" for="invoice_no"
                                                   type="text" />

                                <x-form-select-comp class="col-span-2" wire:model="supplier_id" :options="$suppliers" optionValue="id"
                                                    isDisabled="{{ false }}"
                                                    optionDisplay="supplier_name" label="Supplier*" for="supplier_id" />

                                <x-form-onlydate-picker-comp wire:key="1-purchase_date" class="col-span-1"
                                                             isDisabled="{{ false }}"
                                                             wire:model.lazy="purchase_date"
                                                             label="Purchase Date"
                                                             for="purchase_date" />

                                <x-form-onlydate-picker-comp wire:key="2-due_date" class="col-span-1"
                                                             isDisabled="{{ false }}"
                                                             wire:model.lazy="due_date"
                                                             label="Due Date"
                                                             for="due_date" />

                                <x-form-select-comp class="col-span-1" wire:model="payment_type_id" :options="$paymentTypes" optionValue="id"
                                                    isDisabled="{{ false }}"
                                                    optionDisplay="payment_type_name" label="Payment Type*" for="payment_type_id" />

                                <div class="col-span-6 space-y-4">
                                    <div class="h-[350px] border overflow-y-auto relative rounded-md overflow-hidden shadow-md">
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
                                                    <x-th align="center" width="100px">
                                                        <button wire:click="$emit('searchAddItem')" type="button"
                                                                class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                                            Add New
                                                        </button>
                                                    </x-th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white">
                                                @isset($purchaseDetails)
                                                    @foreach ($purchaseDetails as $key => $pd)
                                                        <tr
                                                            wire:key="{{ $pd['item_id'] . '-' . $pd['item_name'] }}"
                                                            class="divide-x">
                                                            <x-td-slim>{{ $pd['item_name'] }}</x-td-slim>
                                                            <x-td-slim>{{ $pd['invoice_unit'] }}</x-td-slim>
                                                            <x-td-centered-slim class="text-center">
                                                                {{ number_format($pd['price'], 0, '.', ',') }}
                                                            </x-td-centered-slim>
                                                            <x-td-centered-slim class="text-center">{{ $pd['qty'] }}</x-td-centered-slim>
                                                            <x-td-centered-slim class="text-center">
                                                                {{ number_format($pd['qty'] * $pd['price'], 0, '.', ',') }}</x-td-centered-slim>
                                                            <x-td-centered-slim class="text-center">{{ $pd['recipe_unit'] }}
                                                            </x-td-centered-slim>
                                                            <x-td-centered-slim class="text-center">{{ $pd['recipe_qty'] }}
                                                            </x-td-centered-slim>
                                                            <x-td-slim-nopadding>
                                                                <button type="button"
                                                                        wire:click="removePurchaseDetails('{{ $key }}')"
                                                                        class="ml-3 enabled:hover:bg-gray-200 p-1 rounded-md">
                                                                    <svg class="h-5 text-gray-500 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd"
                                                                              d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                              clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                                <button type="button"
                                                                        wire:click="editPurchaseDetailEdit('{{ $key }}')"
                                                                        class="ml-3 enabled:hover:bg-gray-200 p-1 rounded-md">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                         fill="currentColor"
                                                                         class="h-5 text-gray-500 w-5">
                                                                        <path
                                                                              d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                                        <path
                                                                              d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                                    </svg>
                                                                </button>
                                                            </x-td-slim-nopadding>
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-span-2"></div>

                                <x-display-info-comp class="col-span-1" label="Amount"
                                                     displayValue="{{ number_format($amount, 0, '.', ',') }}" />

                                <x-form-input-comp class="col-span-1" wire:model.lazy="discount" label="Discount" for="discount"
                                                   type="text" />

                                <x-form-input-comp class="col-span-1" wire:model.lazy="tax" label="Tax" for="tax"
                                                   type="text" />

                                <x-display-info-comp class="col-span-1" label="Total"
                                                     displayValue="{{ number_format($total, 0, '.', ',') }}" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
            </form>

        </div>


        {{-- <x-slot name="modalLeftAction">
        </x-slot> --}}

        <x-slot name="modalAction">
            <button type="button" wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 focus:outline-none">
                Create
            </button>
        </x-slot>
    @endif
</x-modal>
