<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-reports-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center justify-between space-x-3 w-full">
            <div class="flex items-center space-x-8">
                {{-- <x-table-filter-input class="w-72" wire:model="search" placeholder="Room, Guest or Agent..." /> --}}
                <x-datepicker-inline-label label="From" wire:model="dateFrom" />
                <x-datepicker-inline-label label="To" wire:model="dateTo" />

                <div class="flex items-center space-x-8">

                    <x-inline-checkbox-with-label wire:model="viewOnlyKitchenItem" for="viewOnlyKitchenItem" :isDisabled="false" value="1"
                                                  label="Kitchen Items" />

                    <x-inline-checkbox-with-label wire:model="viewOnlyKitchenItem" for="viewOnlyKitchenItem" :isDisabled="false"
                                                  value="0"
                                                  label="Other Items" />
                </div>
            </div>

            <button type="button"
                    @click="$wire.print().then(open)"
                    class="inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                Print
                <!-- Heroicon name: mini/envelope -->
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                          clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </x-content-header-section>


    <x-sticky-table-wrapper>
        <thead class="bg-gray-50">
            <tr class="divide-x">
                <x-th width="100px" align="center">Sr. No</x-th>
                <x-th width="150px">Purchase Date</x-th>
                <x-th>Item</x-th>
                <x-th width="150px">Invoice Unit</x-th>
                <x-th width="120px" align="center">Price</x-th>
                <x-th width="100px" align="center">Qty</x-th>
                <x-th width="100px" align="center">Amount</x-th>
                <x-th width="100px" align="center">Recipe Unit</x-th>
                <x-th width="100px" align="center">Recipe Qty</x-th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($purchaseDetails as $index => $detail)
                <tr class="divide-x hover:bg-gray-200 transition-colors ease-out duration-150 cursor-pointer">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td>{{ $detail->purchase->purchase_date }}</x-td>
                    <x-td>{{ $detail->item->item_name }}</x-td>
                    <x-td>{{ $detail->invoice_unit }}</x-td>
                    <x-td-slim-with-align align="right">
                        {{ number_format($detail->price, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $detail->qty }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($detail->price * $detail->qty, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td>{{ $detail->item->recipe_unit }}</x-td>
                    <x-td-slim-with-align align="center">{{ $detail->recipe_qty }}</x-td-slim-with-align>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

</x-page-layout>
