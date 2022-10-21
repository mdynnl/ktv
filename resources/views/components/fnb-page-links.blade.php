<x-desktop-sidebar-section title="">
    <div wire:ignore class="space-y-5">
        <x-nav-sidebar-link :href="route('fnb.menu-view')" :active="request()->routeIs('fnb.menu-view')">Food & Beverage</x-nav-sidebar-link>
    </div>
</x-desktop-sidebar-section>
