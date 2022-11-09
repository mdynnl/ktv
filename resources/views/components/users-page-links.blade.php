<x-desktop-sidebar-section title="">
    <div wire:ignore class="space-y-5">
        @can('view any users')
            <x-nav-sidebar-link :href="route('users')" :active="request()->routeIs('users')">Users</x-nav-sidebar-link>
        @endcan
        @can('view roles')
            <x-nav-sidebar-link :href="route('users.roles-permission')" :active="request()->routeIs('users.roles-permission')">Roles & Permissions</x-nav-sidebar-link>
        @endcan
    </div>
</x-desktop-sidebar-section>
