<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-reports-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center justify-between space-x-3 w-full">
            <div class="flex items-center space-x-8">
                <x-datepicker-inline-label label="From" wire:model="dateFrom" />
                <x-datepicker-inline-label label="To" wire:model="dateTo" />

                <x-table-filter-select-comp wire:model="selectedStaffId" label="All Service Staff" :options="$serviceStaffs"
                                            for="selectedStaffId"
                                            optionValue="id" optionDisplay="nick_name" />


                <x-inline-checkbox-with-label wire:model="viewOnlyActive" for="viewOnlyActive" :isDisabled="false" value="1"
                                              label="View Active Only" />



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
                <x-th width="50px"></x-th>
                <x-th align="center" width="80px">Sr. No</x-th>
                <x-th align="center" width="80px">Reg No</x-th>
                <x-th align="center">Name</x-th>
                <x-th align="center" width="150px">Sessions</x-th>
                <x-th align="center" width="150px">Service Rate</x-th>
                <x-th align="center" width="150px">Commission Rate</x-th>
                <x-th align="center" width="150px">Commission Amount</x-th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($commissionSummaries as $index => $summary)
                <tr class="divide-x hover:bg-gray-200 transition-colors ease-out duration-150 cursor-pointer">
                    <x-td-slim-nopadding>
                        <button type="button"
                                wire:click="$emit('showCommissionInvoice', '{{ $summary->service_staff_id }}')"
                                class="enabled:hover:bg-gray-200 p-1 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 text-gray-500 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </button>
                    </x-td-slim-nopadding>
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="center">{{ $summary->service_staff_id }}</x-td-slim-with-align>
                    <x-td-image imagePath="{!! isset($summary->profile_image) ? asset('storage/' . $summary->profile_image) : asset('images/employee.png') !!}"
                                name="{!! $summary->nick_name !!}" />
                    <x-td-slim-with-align align="center">{{ $summary->session_hours }}</x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($summary->service_staff_rate, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($summary->service_staff_commission_rate, 0, '.', ',') }}
                    </x-td-slim-with-align>
                    <x-td-slim-with-align align="right">{{ number_format($summary->commission_amount, 0, '.', ',') }}
                    </x-td-slim-with-align>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    <livewire:live-view-commission-invoice />
</x-page-layout>
