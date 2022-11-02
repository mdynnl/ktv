<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- Some Content --}}
    </x-slot:staticSidebarContent>


    <x-content-header-section>
        <div class="flex items-center space-x-8">
            <div class="flex items-center space-x-4">
                <x-table-filter-input class="w-72" wire:model="search" placeholder="Invoice No..." />

                <x-table-filter-select-comp wire:model="selectedSupplierId" label="Select a Supplier" :options="$suppliers"
                                            for="suppliers"
                                            optionValue="id" optionDisplay="supplier_name" />
            </div>

            <div class="flex items-center space-x-3">
                <x-datepicker-inline-label label="From" wire:model="fromDate" />
                <x-datepicker-inline-label label="To" wire:model="toDate" />
            </div>
        </div>

        <div class="sm:ml-16 sm:flex-none">
            <button wire:click="$emit('createPurchase')" type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                Add Purchase
            </button>
        </div>

    </x-content-header-section>


    <x-sticky-table-wrapper>
        <thead class="bg-gray-50">
            <tr class="divide-x">
                <x-th width="80px">Sr. No</x-th>
                <x-th width="80px">Reg No</x-th>
                <x-th width="150px">Invoice No</x-th>
                <x-th width="150px">Date</x-th>
                <x-th>Supplier</x-th>
                <x-th width="150px" align="center">Amount</x-th>
                <x-th width="150px" align="center">Discount</x-th>
                <x-th width="150px" align="center">Tax</x-th>
                <x-th width="150px" align="center">Total</x-th>
                <x-th width="200px"></x-th>

            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($purchases as $index => $purchase)
                <tr
                    class="divide-x bg-white text-gray-900">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $purchase->id }}</x-td-slim-with-align>
                    <x-td>{{ $purchase->invoice_no }}</x-td>
                    <x-td>{{ $purchase->purchase_date }}</x-td>
                    <x-td>{{ $purchase->supplier->supplier_name }}</x-td>
                    <x-td align="right">{{ $purchase->amount }}</x-td>
                    <x-td align="right">{{ $purchase->discount }}</x-td>
                    <x-td align="right">{{ $purchase->tax }}</x-td>
                    <x-td align="right">{{ $purchase->total }}</x-td>
                    <x-td>
                        <button type="button" wire:click="$emit('editPurchase', {{ $purchase->id }})"
                                class="text-primary hover:text-blue-900">Edit</button>
                        <button type="button" wire:click="$emit('deletePurchase', {{ $purchase->id }})"
                                class="ml-3 text-primary hover:text-blue-900">Delete</button>
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-purchase-create />
    <livewire:live-purchase-edit />
    <livewire:live-purchase-delete />

    <livewire:live-purchase-detail-create />
    <livewire:live-purchase-detail-edit />
    <livewire:live-purchase-detail-delete />
</x-page-layout>
