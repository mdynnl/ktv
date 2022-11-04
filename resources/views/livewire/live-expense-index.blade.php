<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- Some Content --}}
    </x-slot:staticSidebarContent>


    <x-content-header-section>
        <div class="flex items-center space-x-8">
            <div class="flex items-center space-x-4">
                {{-- <x-table-filter-input class="w-72" wire:model="search" placeholder="Invoice No..." /> --}}

                <x-table-filter-select-comp wire:model="selectedExpenseTypeId" label="All Expense Types" :options="$expenseTypes"
                                            for="expenseTypes"
                                            optionValue="id" optionDisplay="expense_type_name" />
            </div>

            <div class="flex items-center space-x-3">
                <x-datepicker-inline-label label="From" wire:model="fromDate" />
                <x-datepicker-inline-label label="To" wire:model="toDate" />
            </div>
        </div>

        <div class="sm:ml-16 sm:flex-none">
            @can('create', App\Models\Expense::class)
                <button wire:click="$emit('createExpense')" type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add Expense
                </button>
            @endcan

            @can('viewAny', App\Models\Expense::class)
                <button wire:click="print" type="button"
                        class="ml-3 inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Print
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
                <x-th width="150px">Expense Type</x-th>
                <x-th>Description</x-th>
                <x-th width="150px" align="center">Price</x-th>
                <x-th width="150px" align="center">Qty</x-th>
                <x-th width="150px" align="center">Amount</x-th>
                <x-th width="200px"></x-th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($expenses as $index => $expense)
                <tr
                    class="divide-x bg-white text-gray-900">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $expense->id }}</x-td-slim-with-align>
                    <x-td>{{ $expense->expense_date }}</x-td>
                    <x-td>{{ $expense->expenseType->expense_type_name }}</x-td>
                    <x-td>{{ $expense->description }}</x-td>
                    <x-td-slim-with-align align="right">{{ number_format($expense->price, 0, '.', ',') }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $expense->qty }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($expense->price * $expense->qty, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td>
                        @can('update', $expense)
                            <button type="button" wire:click="$emit('editExpense', {{ $expense->id }})"
                                    class="text-primary hover:text-blue-900">Edit</button>
                        @endcan

                        @can('delete', $expense)
                            <button type="button" wire:click="$emit('deleteExpense', {{ $expense->id }})"
                                    class="ml-3 text-primary hover:text-blue-900">Delete</button>
                        @endcan
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-expense-type-create />

    <livewire:live-expense-create />
    <livewire:live-expense-edit />
    <livewire:live-expense-delete />
</x-page-layout>
