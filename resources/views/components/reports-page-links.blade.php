<x-desktop-sidebar-section title="">
    <div wire:ignore class="space-y-5">
        <x-nav-sidebar-link :href="route('report.dashboard')" :active="request()->routeIs('report.dashboard')">Dashboard</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.sales-detail')" :active="request()->routeIs('report.sales-detail')">Sales Detail</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.sales-summary')" :active="request()->routeIs('report.sales-summary')">Sales Summary</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.purchase-details')" :active="request()->routeIs('report.purchase-details')">Purchase Detail</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.purchase-summary')" :active="request()->routeIs('report.purchase-summary')">Purchase Summary</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.commission-details')" :active="request()->routeIs('report.commission-details')">Commission Detail</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.commission-summary')" :active="request()->routeIs('report.commission-summary')">Commission Summary</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.expense-details')" :active="request()->routeIs('report.expense-details')">Expense Detail</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.expense-summary')" :active="request()->routeIs('report.expense-summary')">Expense Summary</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('report.profit-summary')" :active="request()->routeIs('report.profit-summary')">Profit Summary</x-nav-sidebar-link>
        {{-- <x-nav-sidebar-link :href="route('reports.departure')" :active="request()->routeIs('reports.departure')">Departure</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('reports.inhouse')" :active="request()->routeIs('reports.inhouse')">Inhouse</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('reports.manager-report')" :active="request()->routeIs('reports.manager-report')">Manager</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('reports.guest-ledger')" :active="request()->routeIs('reports.guest-ledger')">Guest Ledger</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('reports.city-ledger')" :active="request()->routeIs('reports.city-ledger')">City Ledger</x-nav-sidebar-link>
        <x-nav-sidebar-link :href="route('reports.payment-detail')" :active="request()->routeIs('reports.payment-detail')">Payment Details</x-nav-sidebar-link> --}}
    </div>
</x-desktop-sidebar-section>
