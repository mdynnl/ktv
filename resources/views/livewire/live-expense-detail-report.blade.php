<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-reports-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center justify-between space-x-3 w-full">
            <div class="flex items-center space-x-8">
                <x-datepicker-inline-label label="From" wire:model="fromDate" />
                <x-datepicker-inline-label label="To" wire:model="toDate" />

                {{-- <x-table-filter-select-comp wire:model="selectedStaffId" label="All Service Staff" :options="$serviceStaffs"
                                            for="selectedStaffId"
                                            optionValue="id" optionDisplay="nick_name" />


                <x-inline-checkbox-with-label wire:model="viewOnlyActive" for="viewOnlyActive" :isDisabled="false" value="1"
                                              label="View Active Only" />
 --}}


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


    @foreach ($expenseGroup as $key => $expenses)
        <div class="mb-8">
            <div class="mb-3">
                <h1>Expense Type: {{ $key }}</h1>
            </div>
            <x-sticky-table-wrapper-no-pb>
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
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($expenses as $index => $expense)
                        <tr
                            class="divide-x bg-white text-gray-900">
                            <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="center">{{ $expense->id }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="left">{{ $expense->expense_date }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="left">{{ $expense->expenseType->expense_type_name }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="left">{{ $expense->description }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="right">{{ number_format($expense->price, 0, '.', ',') }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="center">{{ $expense->qty }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="right">{{ number_format($expense->price * $expense->qty, 0, '.', ',') }}
                            </x-td-slim-with-align>
                        </tr>
                    @endforeach
                    <tr class="divide-x">
                        <x-td-slim-with-align-no-bb colspan="7" align="right"><span class="font-extrabold pr-10">Total</span>
                        </x-td-slim-with-align-no-bb>
                        <x-td-slim-with-align-no-bb colspan="1" align="right">
                            <span class="font-bold">
                                {{ number_format($expenses->sum('amount'), 0, '.', ',') }}
                            </span>
                        </x-td-slim-with-align-no-bb>
                    </tr>
                </tbody>
            </x-sticky-table-wrapper-no-pb>
        </div>
    @endforeach


</x-page-layout>
