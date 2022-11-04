<x-page-layout>
    <x-slot:staticSidebarContent>
    </x-slot:staticSidebarContent>

    <x-content-header-section>
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
                       placeholder="Name, email & phone...">
            </div>
        </div>
        <div class="sm:ml-16 sm:flex-none">
            @can('create', App\Models\Customer::class)
                <button wire:click="$emit('createCustomer')" type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add Customer
                </button>
            @endcan

        </div>
    </x-content-header-section>

    <x-sticky-table-wrapper>
        <thead class="bg-gray-50">
            <tr class="divide-x">
                <x-th width="80px">Sr. No</x-th>
                <x-th>Name</x-th>
                <x-th>Phone No.</x-th>
                <x-th>Address</x-th>
                <x-th></x-th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($customers as $index => $customer)
                <tr class="divide-x">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td>{{ $customer->customer_name }}</x-td>
                    {{-- <x-td align="right">{{ isset($customer->discount) ? $customer->discount . '%' : '0%' }}</x-td> --}}
                    <x-td>{{ $customer->phone }}</x-td>
                    <x-td>{{ $customer->address }}</x-td>
                    <x-td>
                        <div class="inline-flex space-x-3 items-center">
                            @can('update', $customer)
                                <button type="button" wire:click="$emit('editCustomer', {{ $customer->id }})"
                                        class="text-primary hover:text-blue-900">Edit</button>
                            @endcan
                            @can('delete', $customer)
                                <button type="button" wire:click="$emit('deleteCustomer', {{ $customer->id }})"
                                        class="text-primary hover:text-blue-900">Delete</button>
                            @endcan
                        </div>
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-customer-create />
    <livewire:live-customer-edit />
    <livewire:live-customer-delete />
</x-page-layout>
