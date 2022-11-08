<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- Some Content --}}
    </x-slot:staticSidebarContent>


    <x-content-header-section>
        <div class="flex items-center space-x-8">
            <div class="flex items-center space-x-4">
                {{-- <x-table-filter-input class="w-72" wire:model="search" placeholder="Invoice No..." /> --}}

                <x-table-filter-select-comp wire:model="selectedStockOutTypeId" label="All Stockout Type" :options="$stockOutTypes"
                                            for="selectedStockOutTypeId"
                                            optionValue="id" optionDisplay="stock_out_type_name" />
            </div>

            <div class="flex items-center space-x-3">
                <x-datepicker-inline-label label="From" wire:model="fromDate" />
                <x-datepicker-inline-label label="To" wire:model="toDate" />
            </div>
        </div>

        <div class="sm:ml-16 sm:flex-none">
            @can('create', App\Models\StockOut::class)
                <button wire:click="$emit('createStockout')" type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add Stockout
                </button>
            @endcan

        </div>

    </x-content-header-section>


    <x-sticky-table-wrapper>
        <thead class="bg-gray-50">
            <tr class="divide-x">
                <x-th width="50px" align="center">Sr. No</x-th>
                <x-th width="50px" align="center">Reg No</x-th>
                <x-th width="150px">Date</x-th>
                <x-th width="150px">Item</x-th>
                <x-th width="80px" align="center">Qty</x-th>
                <x-th width="80px" align="center">Cost</x-th>
                <x-th width="80px" align="center">Amount</x-th>
                <x-th width="150px">Stockout Type</x-th>
                <x-th width="150px" align="center">Remark</x-th>
                <x-th width="200px"></x-th>

            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($stockouts as $index => $stockout)
                <tr
                    class="divide-x bg-white text-gray-900">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $stockout->id }}</x-td-slim-with-align>
                    <x-td>{{ $stockout->stock_out_date }}</x-td>
                    <x-td>{{ $stockout->item->item_name }}</x-td>
                    <x-td-slim-with-align align="center">{{ $stockout->qty }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($stockout->price, 0, '.', ',') }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($stockout->price * $stockout->qty, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td>{{ $stockout->stockOutType->stock_out_type_name }}</x-td>
                    <x-td>{{ $stockout->remark }}</x-td>
                    <x-td>
                        @can('update', $stockout)
                            <button type="button" wire:click="$emit('editStockout', {{ $stockout->id }})"
                                    class="text-primary hover:text-blue-900">Edit</button>
                        @endcan

                        @can('delete', $stockout)
                            <button type="button" wire:click="$emit('deleteStockout', {{ $stockout->id }})"
                                    class="ml-3 text-primary hover:text-blue-900">Delete</button>
                        @endcan
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-stock-out-create />
    <livewire:live-stock-out-edit />
    <livewire:live-stock-out-delete />
</x-page-layout>
