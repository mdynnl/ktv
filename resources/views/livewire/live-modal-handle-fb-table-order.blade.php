<x-modal wire:model="showHandleTableOrderModal" size="xxl" cancelButtonLabel="Close">
    {{-- @isset($table_id) --}}
    @isset($inhouse_id)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold flex justify-between items-center w-full">
                <span>
                    Room No: {{ $room_no }}
                </span>
                {{-- @isset($invoice_no)
                    <span>
                        Invoice: {{ $invoice_no }}
                    </span>
                @endisset --}}
            </h1>
        </x-slot>

        <div class="min-h-[24rem]">
            <div class="grid grid-cols-2 gap-x-5 mt-3">
                <div>
                    <div class="mb-3">
                        <div class="flex items-end space-x-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <div class="isolate inline-flex rounded-md shadow-sm mt-1">
                                    @foreach ($categories as $category)
                                        <button type="button"
                                                wire:click="$set('selectedCategoryId', {{ $category->id }})"
                                                @class([
                                                    'relative inline-flex items-center rounded-l-md  border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                                        $loop->first,
                                                    'relative -ml-px inline-flex items-center border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                                        !$loop->first || $loop->last,
                                                    'relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                                        $loop->last,
                                                    'bg-primary text-white hover:bg-blue-900' =>
                                                        $selectedCategoryId == $category->id,
                                                    'bg-white text-gray-700 hover:bg-gray-50' =>
                                                        $selectedCategoryId != $category->id,
                                                ])>
                                            {{ $category->food_category_name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-1">
                                <x-form-input-comp wire:model="fnbSearch" label="Search Food & Beverage" for="fnbSearch" type="text"
                                                   placeholder="Search..." />
                            </div>

                        </div>
                    </div>

                    <div
                         class="mb-3 border rounded-md flex flex-wrap gap-x-3 gap-y-3 h-56 overflow-hidden overflow-y-auto p-3">
                        @foreach ($foodTypes as $type)
                            <x-fb-menu-card-button wire:click="$set('selectedFoodTypeId', {{ $type->id }})"
                                                   active="{{ $selectedFoodTypeId == $type->id }}"
                                                   label="{{ ucwords($type->food_type_name) }}" />
                        @endforeach
                    </div>

                    <div
                         class="border rounded-md flex flex-wrap gap-x-3 gap-y-3 h-56 overflow-hidden overflow-y-auto p-3">
                        @foreach ($foods as $food)
                            <x-fb-menu-card-button-with-image wire:click="addToOrder({{ $food->id }})"
                                                              :active="false"
                                                              label="{{ ucwords($food->food_name) }}"
                                                              :price="$food->price"
                                                              :image="$food->getImage" />
                        @endforeach
                    </div>
                </div>

                <div>
                    {{-- <div class="mb-3"> --}}
                    {{-- <div class="grid grid-cols-6 gap-x-3"> --}}
                    {{-- <x-combobox class="col-span-3" wire:model="customerSearch" label="Customer" placeholder="Walk In">
                                @foreach ($customers as $customer)
                                    <li wire:key="{{ $customer->id . '-customer' }}"
                                        wire:click="selectCustomer('{{ $customer->id }}')"
                                        class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-gray-100"
                                        id="option-0"
                                        role="option"
                                        tabindex="-1">
                                        <span class="block truncate">{{ $customer->customer_name }}</span>
                                    </li>
                                @endforeach
                                </ul>
                            </x-combobox> --}}

                    {{-- <x-form-number-input-comp class="col-span-1" wire:model.lazy="pax" label="Pax" for="pax"
                                                      min="1" />
                            <x-form-select-comp class="col-span-2" wire:model="payment_type_id" :options="$paymentTypes" optionValue="id"
                                                optionDisplay="payment_type_name" :hasBlankOption="false" label="Payment Type"
                                                for="selectedPaymentTypeId" /> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}

                    <div class="max-h-[66rem] h-full border overflow-y-scroll relative rounded-md overflow-hidden mb-3">
                        <table class="min-w-full border-separate " style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr class="divide-x">
                                    <x-th-slim-with-align align="left">Food & Beverage</x-th-slim-with-align>
                                    <x-th-slim-with-align align="center">Price</x-th-slim-with-align>
                                    <x-th-slim-with-align align="center">Qty</x-th-slim-with-align>
                                    <x-th-slim-with-align align="center">Amount</x-th-slim-with-align>
                                    <x-th-slim-with-align align="center"></x-th-slim-with-align>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($orderDetails as $key => $orderDetail)
                                    <tr
                                        @class(['divide-x', 'bg-gray-100' => !isset($orderDetail['id'])])>
                                        <x-td-slim-with-align align="left">{{ ucwords($orderDetail['food_name']) }}</x-td-slim-with-align>
                                        <x-td-slim-with-align align="right">{{ $orderDetail['price'] }}</x-td-slim-with-align>
                                        <x-td-slim-with-align align="center">
                                            <div class="flex gap-x-4 items-center justify-center">
                                                @if (!isset($orderDetail['id']))
                                                    {{-- <button wire:click="changeQty('{{ $key }}', '{{ $orderDetail['food_id'] }}', false)" --}}
                                                    <button wire:click="changeQty('{{ $key }}', false)"
                                                            class="bg-primary border p-1 rounded-md text-white">
                                                        <span class="flex items-center justify-center leading-none px-1 text-xl">&minus;</span>
                                                    </button>
                                                @endif
                                                <span class="flex items-center justify-center w-8">
                                                    {{ $orderDetail['qty'] }}
                                                </span>
                                                @if (!isset($orderDetail['id']))
                                                    <button
                                                            wire:click="changeQty('{{ $key }}')"
                                                            class="disabled:bg-gray-300 enabled:bg-primary border p-1 rounded-md text-white">
                                                        <span class="flex items-center justify-center leading-none px-1 text-xl">&plus;</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </x-td-slim-with-align>
                                        <x-td-slim-with-align align="right">{{ $orderDetail['amount'] }}</x-td-slim-with-align>
                                        <x-td-slim-with-align align="center">
                                            @if (isset($orderDetail['id']))
                                                {{-- <button wire:click="showOrderDelete('{{ $key }}')"
                                                        class="hover:bg-gray-200 p-1 rounded-md">

                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                         class="h-5 text-gray-500 w-5">
                                                        <path fill-rule="evenodd"
                                                              d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                              clip-rule="evenodd" />
                                                    </svg>
                                                </button> --}}
                                            @else
                                                <button type="button" wire:click="addRemark('{{ $key }}')"
                                                        class="hover:bg-gray-200 p-1 rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                         class="h-5 text-gray-500 w-5">
                                                        <path
                                                              d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                                        <path
                                                              d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </x-td-slim-with-align>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="grid grid-cols-5 gap-x-3 mt-px">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Sub Total</label>
                            <div class="mt-1">
                                <div
                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                    <span>{{ round($sub_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Discount</label>
                            <div class="mt-1">
                                <div
                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                    <span>{{ $discount_percent . '%' }}</span>
                                </div>
                            </div>
                        </div>
                        <x-form-input-with-disable-comp class="col-span-1" wire:model.lazy="discount_amount"
                                                        isDisabled="{{ !isset($customer_id) }}" for="discount_amount" type="text"
                                                        label="Discount Amount" />
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Total</label>
                            <div class="mt-1">
                                <div
                                     class="bg-gray-100 block border border-gray-300 py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
                                    @php
                                        $total = $sub_total - $discount_amount;
                                    @endphp
                                    <span>{{ $total }}</span>
                                </div>
                            </div>
                        </div>

                    </div> --}}
                </div>
            </div>
        </div>

        {{-- <x-slot name="modalLeftAction">
            <button {{ isset($order_id) ? '' : 'disabled' }} type="button" wire:click="showKitchenOrderPrintModal"
                    class="ml-3 inline-flex items-center rounded-md border border-transparent disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 px-4 py-2 text-sm font-medium  shadow-sm focus:outline-none ">
                Kitchen Orders
                <!-- Heroicon name: mini/printer -->
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                          clip-rule="evenodd" />
                </svg>
            </button>

            <button {{ isset($order_id) ? '' : 'disabled' }} type="button" @click="$wire.printPreBill().then(open)"
                    class="ml-3 inline-flex items-center rounded-md border border-transparent disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 px-4 py-2 text-sm font-medium  shadow-sm focus:outline-none ">
                Pre Bill
                <!-- Heroicon name: mini/printer -->
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                          clip-rule="evenodd" />
                </svg>
            </button>

            <button {{ isset($order_id) ? '' : 'disabled' }} type="button" @click="$wire.printBill().then(open)"
                    class="ml-3 inline-flex items-center rounded-md border border-transparent disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 px-4 py-2 text-sm font-medium  shadow-sm focus:outline-none ">
                Bill
                <!-- Heroicon name: mini/printer -->
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                          clip-rule="evenodd" />
                </svg>
            </button>
        </x-slot> --}}

        <x-slot name="modalAction">
            <button {{ $isDirty ? '' : 'disabled' }} type="button" @click="$wire.placeOrder().then(open)"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 focus:outline-none">
                Place Order
            </button>
            {{-- <button {{ isset($order_id) ? '' : 'disabled' }} type="button" wire:click="clearTable"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 focus:outline-none">
                Clear Table
            </button> --}}
        </x-slot>
    @endisset

    {{-- Remark Input Modal --}}
    <div wire:key="1-modal">
        <div x-data="{
            showRemarkInputModal: @entangle('showRemarkInputModal')
        }">
            <div x-show="showRemarkInputModal" x-cloak class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showRemarkInputModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    @if (!empty($editingItem))
                        <div class="flex-1 px-4 py-5 text-sm">
                            <div class="grid grid-cols-6 gap-y-3">
                                <x-form-input-comp wire:model.defer="remark" class="col-span-6" type="text"
                                                   label="Add Remark for Item: {{ ucwords($editingItem['food_name']) }}"
                                                   for="remark" />
                            </div>
                        </div>
                    @endif

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showRemarkInputModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                Close
                            </button>
                            <button wire:click="saveRemark" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Delete Modal --}}
    <div wire:key="2-modal">
        <div x-data="{
            showOrderDeleteModal: @entangle('showOrderDeleteModal')
        }">
            <div x-show="showOrderDeleteModal" x-cloak class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showOrderDeleteModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    @if (!empty($editingItem))
                        <div class="flex-1 px-4 py-5 text-sm">
                            <h1 class="mb-3">
                                Item: <strong class="text-red-500">{{ ucwords($editingItem['food_name']) }}</strong> is currently on
                                kitchen order. <br>
                            </h1>
                            <div class="flex justify-between items-center space-x-3">
                                <div>
                                    <span>Ordered Qty: {{ $editingItem['qty'] }}</span>
                                </div>


                                <div class="flex items-center space-x-3">
                                    <p>
                                        <span>Cancelling Qty: </span>
                                        <span class="inline-flex px-2 py-1.5">{{ $editingItem['qtyForReduction'] }}</span>

                                    </p>
                                    <button
                                            {{ $editingItem['qtyForReduction'] == 1 ? 'disabled' : '' }}
                                            wire:click="reduceQty(false)"
                                            class="disabled:bg-gray-300 enabled:bg-primary border p-1 rounded-md text-white">
                                        <span class="flex items-center justify-center leading-none px-1 text-xl">&minus;</span>
                                    </button>
                                    <button
                                            {{ $editingItem['qtyForReduction'] == $editingItem['qty'] ? 'disabled' : '' }}
                                            wire:click="reduceQty"
                                            class="disabled:bg-gray-300 enabled:bg-primary border p-1 rounded-md text-white">
                                        <span class="flex items-center justify-center leading-none px-1 text-xl">&plus;</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showOrderDeleteModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                Close
                            </button>
                            <button
                                    {{ $isModalDirty ? '' : 'disabled' }}
                                    wire:click="confirmDelete" type="button"
                                    class="inline-flex items-center rounded border border-transparent disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 px-2.5 py-1.5 text-xs font-medium shadow-sm focus:outline-none">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Qty Reduce Confirmation Modal --}}
    <div wire:key="3-modal">
        <div x-data="{
            showDeleteConfirmationModal: @entangle('showDeleteConfirmationModal'),
        }">
            <div x-show="showDeleteConfirmationModal" x-cloak class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showDeleteConfirmationModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    @if (!empty($confirmingItem))
                        <div class="flex-1 px-4 py-5 text-sm">
                            <p>{{ $confirmingItem['message'] }}</p>
                        </div>
                    @endif

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showDeleteConfirmationModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                No
                            </button>
                            <button wire:click="delete" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Clear Table Modal --}}
    <div wire:key="4-modal">
        <div x-data="{
            showClearTableConfirmationModal: @entangle('showClearTableConfirmationModal'),
        }">
            <div x-show="showClearTableConfirmationModal" x-cloak class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showClearTableConfirmationModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    <div class="flex-1 px-4 py-5 text-sm">
                        <p>Are you sure you want to clear this table ?</p>
                    </div>

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showClearTableConfirmationModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                No
                            </button>
                            <button wire:click="confirmClearTable" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kitchen Order Print Modal --}}
    <div wire:key="5-modal">
        <div x-data="{
            showKitchenOrderPrintModal: @entangle('showKitchenOrderPrintModal'),
        }">
            <div x-show="showKitchenOrderPrintModal" x-cloak class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showKitchenOrderPrintModal = false"
                     class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    <div class="flex-1 px-4 py-5 text-sm">
                        <div>
                            <label class="block font-medium text-gray-700">Print</label>
                            <fieldset class="flex h-10 mt-1">
                                <div class="sm:flex sm:items-center sm:space-y-0 sm:space-x-5">
                                    <div class="flex items-center">
                                        <input wire:model="printKitchenOrder" id="kitchen_order" name="kitchen_order"
                                               type="radio"
                                               value="1"
                                               class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                        <label for="kitchen_order" class="ml-3 block text-sm font-medium text-gray-700">
                                            Kitchen Order
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input wire:model="printKitchenOrder" id="kitchen_cancel_order" name="kitchen_cancel_order"
                                               type="radio"
                                               value="0"
                                               class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                        <label for="kitchen_cancel_order" class="ml-3 block text-sm font-medium text-gray-700">
                                            Canceled Kitchen Order
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="">
                            <label for="order_time"
                                   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Select Order Time</label>
                            <div class="mt-1 sm:mt-0 sm:col-span-3">
                                <select wire:model="orderTimeSelectedForPrinting"
                                        id="order_time" name="order_time"
                                        class="max-w-lg block enabled:focus:ring-primary enabled:focus:border-primary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @for ($i = 1; $i <= $order_time; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showKitchenOrderPrintModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            <button @click="$wire.printSelectedKitchenPrintTypeOrders().then(open)" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-modal>
