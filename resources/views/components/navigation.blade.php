<div wire:ignore class="flex-1 flex space-x-3">
    @can('view inhouses')
        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">KTV</x-nav-link>
    @endcan
    @can('view food and beverages')
        <x-nav-link :href="route('fnb.menu-view')" :active="request()->routeIs('fnb.menu-view') || request()->routeIs('fnb.*')">F&B</x-nav-link>
    @endcan
    @can('view service staffs')
        <x-nav-link :href="route('service-staff.index')" :active="request()->routeIs('service-staff.index') || request()->routeIs('service-staff.*')">Service Staff</x-nav-link>
    @endcan
    @can('view rooms')
        <x-nav-link :href="route('room.index')" :active="request()->routeIs('room.index') || request()->routeIs('room.*')">Rooms</x-nav-link>
    @endcan
    @can('view customers')
        <x-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.index') || request()->routeIs('customer.*')">Customers</x-nav-link>
    @endcan
    @can('view items')
        <x-nav-link :href="route('item.index')" :active="request()->routeIs('item.index')">Items</x-nav-link>
    @endcan
    @can('view suppliers')
        <x-nav-link :href="route('supplier.index')" :active="request()->routeIs('supplier.index')">Suppliers</x-nav-link>
    @endcan

    @can('view purchases')
        <x-nav-link :href="route('purchase.index')" :active="request()->routeIs('purchase.index')">Purchases</x-nav-link>
    @endcan

    @can('view stockouts')
        <x-nav-link :href="route('stockout.index')" :active="request()->routeIs('stockout.index')">Stockouts</x-nav-link>
    @endcan


    @can('view expenses')
        <x-nav-link :href="route('expense.index')" :active="request()->routeIs('expense.index') || request()->routeIs('expense.*')">Expenses</x-nav-link>
    @endcan

    @can('view reports')
        <x-nav-link :href="route('report.dashboard')" :active="request()->routeIs('report.dashboard') || request()->routeIs('report.*')">Reports</x-nav-link>
    @endcan

    @can('view any users')
        <x-nav-link :href="route('users')" :active="request()->routeIs('users') || request()->routeIs('users.*')">Users</x-nav-link>
    @endcan
</div>
<div class="ml-4 flex items-center md:ml-6">
    <button wire:click="$emit('runNightAudit')" type="button"
            class="mr-6 inline-flex items-center rounded border border-transparent uppercase bg-gray-800 px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none">
        Run Audit
    </button>

    <!-- Profile dropdown -->
    <x-profile-dropdown>
        {{-- <x-dropdown-link href="{{ route('profile', auth()->id()) }}" role="menuitem" tabindex="-1">{{ __('Your Profile') }}</x-dropdown-link> --}}
        <button type="button" wire:click="$emit('changePassword', '{{ auth()->id() }}')"
                class="w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            Change Password
        </button>

        {{-- <x-dropdown-link role="menuitem" tabindex="-1" href="{{ route('profile.change-passowrd') }}">{{ __('Change Password') }}
        </x-dropdown-link> --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link
                             role="menuitem"
                             tabindex="-1"
                             :href="route('logout')"
                             onclick="event.preventDefault();
														this.closest('form').submit();">
                {{ __('Sign Out') }}
            </x-dropdown-link>
        </form>
    </x-profile-dropdown>
</div>
