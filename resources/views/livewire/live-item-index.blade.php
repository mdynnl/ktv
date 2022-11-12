<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- <x-finance-page-links /> --}}
    </x-slot:staticSidebarContent>


    <x-content-header-section>
        <div class="flex items-center space-x-8">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 sr-only">Search</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                  clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model="search" type="text" name="search" id="search"
                           class="focus:ring-primary focus:border-primary block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                           placeholder="Search items...">
                </div>
            </div>
            <div>
                <x-inline-checkbox-with-label wire:model="reorderOnly" for="reorderOnly" :isDisabled="false" label="View Reorder Only"
                                              value="1" />
            </div>
        </div>

        <div class="sm:ml-16 sm:flex-none">
            @can('create', App\Models\Item::class)
                <button wire:click="$emit('createItem')" type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add Item
                </button>
            @endcan

            @can('viewAny', App\Models\Item::class)
                <button @click="$wire.print().then(open)" type="button"
                        class="ml-3 inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Print
                </button>
            @endcan
        </div>

    </x-content-header-section>


    <x-sticky-table-wrapper>
        <thead class="bg-gray-50">
            <tr class="divide-x">
                <x-th width="80px">Sr. No</x-th>
                <x-th class="w-full">Item</x-th>
                <x-th width="100px">Recipe Unit</x-th>
                <x-th width="100px" align="center">Recipe Price</x-th>
                <x-th width="100px" align="center">Reorder</x-th>
                <x-th width="100px" align="center">Current Qty</x-th>
                {{-- <x-th width="100px" align="center">HK Store</x-th> --}}
                <x-th width="200px"></x-th>

            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($items as $index => $item)
                <tr
                    class="divide-x bg-white text-gray-900">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td>{{ $item->item_name }} <br>
                    </x-td>
                    <x-td>{{ $item->recipe_unit }}</x-td>
                    <x-td align="right">{{ number_format($item->recipe_price, 0, '.', ',') }}</x-td>
                    <x-td align="center">{{ $item->reorder }}</x-td>
                    <x-td align="center">
                        {{ $item->current_qty }}
                    </x-td>
                    <x-td>
                        @can('update', $item)
                            <button type="button" wire:click="$emit('editItem', {{ $item->id }})"
                                    class="text-primary hover:text-blue-900">Edit</button>
                        @endcan

                        @can('delete', $item)
                            <button type="button" wire:click="$emit('deleteItem', {{ $item->id }})"
                                    class="ml-3 text-primary hover:text-blue-900">Delete</button>
                        @endcan
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-item-create />
    <livewire:live-item-edit />
    <livewire:live-item-delete />
</x-page-layout>
