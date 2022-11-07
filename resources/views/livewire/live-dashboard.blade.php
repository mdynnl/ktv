<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-reports-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center justify-between space-x-3 w-full">
            <div class="flex items-center space-x-8">
                <x-datepicker-inline-label label="From" wire:model="fromDate" />
                <x-datepicker-inline-label label="To" wire:model="toDate" />



                <x-inline-radio-wrapper>
                    <x-inline-radio-with-label wire:model="viewDailyMonthlyYearly" value="1" for="viewType_daily" label="Daily" />
                    <x-inline-radio-with-label wire:model="viewDailyMonthlyYearly" value="2" for="viewType_monthly" label="Monthly" />
                    <x-inline-radio-with-label wire:model="viewDailyMonthlyYearly" value="3" for="viewType_yearly" label="Yearly" />
                </x-inline-radio-wrapper>
            </div>

            <div x-data="{
                showDataLabels: @entangle('showDataLabels'),
            }" class="relative inline-block text-left">
                <div class="flex items-center">
                    <button type="button"
                            @click="showDataLabels = !showDataLabels"
                            :class="showDataLabels ? 'bg-primary' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none "
                            role="switch" aria-checked="false" aria-labelledby="annual-billing-label">
                        <span aria-hidden="true"
                              :class="showDataLabels ? 'translate-x-5' : 'translate-x-0'"
                              class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                    <span class="ml-3" id="annual-billing-label">
                        <span class="text-sm font-medium text-gray-900">Show Data Labels</span>
                    </span>
                </div>
            </div>
        </div>
    </x-content-header-section>

    <div class="grid grid-cols-6 gap-x-8 gap-y-12 mt-10">
        <div class="col-span-2 bg-white shadow-md border rounded-md overflow-hidden">
            <div class="mt-3 px-6 py-1.5">
                <h1 class="font-bold text-2xl leading-none">MMK {{ number_format($salesAndGrossProfits->sum('total'), 0, '.', ',') }}</h1>
                <p>Sales</p>
            </div>
            <div class="h-52">
                <livewire:livewire-area-chart
                                              key="{{ $salesAreaChartModel->reactiveKey() }}"
                                              :area-chart-model="$salesAreaChartModel" />
            </div>
        </div>

        <div class="col-span-2 bg-white shadow-md border rounded-md overflow-hidden">
            <div class="mt-3 px-6 py-1.5">
                <h1 class="font-bold text-2xl leading-none">MMK {{ number_format($salesAndGrossProfits->sum('gross_profit'), 0, '.', ',') }}
                </h1>
                <p>Gross Profits</p>
            </div>
            <div class="h-52">
                <livewire:livewire-area-chart
                                              key="{{ $grossProfitsAreaChartModel->reactiveKey() }}"
                                              :area-chart-model="$grossProfitsAreaChartModel" />
            </div>
        </div>

        <div class="col-span-2 bg-white shadow-md border rounded-md overflow-hidden">
            <div class="mt-3 px-6 py-1.5">
                <h1 class="font-bold text-2xl leading-none">MMK {{ number_format($expenses->sum('amount'), 0, '.', ',') }}</h1>
                <p>Expenses</p>
            </div>
            <div class="h-52">

                <livewire:livewire-area-chart
                                              key="{{ $expenseAreaChartModel->reactiveKey() }}"
                                              :area-chart-model="$expenseAreaChartModel" />
            </div>
        </div>

        <div class="col-span-3 bg-white shadow-md border rounded-md overflow-hidden">
            <div class="mt-3 px-6 py-1.5">
                <h1 class="font-bold text-2xl leading-none">Top 10 Service Staffs</h1>
            </div>
            <div class="h-96 pl-3 pr-4">

                <livewire:livewire-column-chart
                                                key="{{ $top10ServiceStaffColumnChartModel->reactiveKey() }}"
                                                :column-chart-model="$top10ServiceStaffColumnChartModel" />
            </div>
        </div>

        <div class="col-span-3 bg-white shadow-md border rounded-md overflow-hidden">
            <div class="mt-3 px-6 py-1.5">
                <h1 class="font-bold text-2xl leading-none">Sales Overview</h1>
            </div>
            <div class="h-96 pl-3 pr-4">
                <livewire:livewire-line-chart
                                              key="{{ $overviewSalesMultiLineChartModel->reactiveKey() }}"
                                              :line-chart-model="$overviewSalesMultiLineChartModel" />
            </div>
        </div>
    </div>
</x-page-layout>
