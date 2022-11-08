<div x-data="{ showOffCanvasMenu: false, showDropDownMenu: false, showDesktopSidebar: $persist(true) }">

    {{-- Mobile off Canvas Menu --}}
    <div
         x-cloak
         x-show="showOffCanvasMenu"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="relative z-40 md:hidden" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

        <div
             x-show="showOffCanvasMenu"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-0 flex z-40">

            <div
                 @click.outside="showOffCanvasMenu = false"
                 x-show="showOffCanvasMenu"
                 x-transition:enter="ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="relative flex-1 flex flex-col max-w-xs w-full pb-4 bg-primary">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button
                            @click="showOffCanvasMenu = false"
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center justify-center px-4 h-16">
                    <h1 class="text-white text-lg">{{ config('app.name') }}</h1>
                </div>

                <div class="my-6 flex-1 h-0 overflow-y-auto">
                    <div class="px-2 space-y-1">
                        @if (isset($staticSidebarContent))
                            {{ $staticSidebarContent }}
                        @else
                            <h1>Default Content</h1>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>
    {{-- End of Mobile off Canvas Menu --}}




    <!-- Static sidebar for desktop -->
    <div x-cloak x-show="showDesktopSidebar" class="hidden bg-primary md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex items-center flex-shrink-0 px-4 h-16">
            {{-- <h1 class="text-white text-lg font-normal">KTV POS System</h1> --}}
            <h1 class="text-white text-lg font-normal">{{ config('app.name') }}</h1>
        </div>

        <div class="flex flex-col flex-grow overflow-y-auto">
            <div class="py-3 flex-1 flex flex-col">
                <div class="flex-1 px-2 pb-4">
                    @if (isset($staticSidebarContent))
                        {{ $staticSidebarContent }}
                    @else
                        <h1>Default Content</h1>
                    @endif
                    {{-- <x-desktop-sidebar-section title="Night Audit">
                        <button wire:click="$emit('runNightAudit')" type="button"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Run Audit
                        </button>
                    </x-desktop-sidebar-section> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- End of Static sidebar for desktop --}}





    {{-- Right Side Content --}}
    <div x-cloak :class="showDesktopSidebar ? 'md:pl-64' : ''" class=" flex flex-col flex-1">
        {{-- Navbar --}}
        <div class="sticky top-0 z-50 flex-shrink-0 flex h-16 bg-white shadow">
            <button
                    @click="showOffCanvasMenu = true"
                    type="button"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <!-- Heroicon name: outline/menu-alt-2 -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <button
                    @click="showDesktopSidebar = !showDesktopSidebar"
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary hidden md:inline-block">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                     stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <div class="flex-1 px-4 md:px-8 flex justify-between">
                <x-navigation></x-navigation>
            </div>
        </div>
        {{-- End of Navbar --}}



        {{-- Main Content --}}
        <main>
            <div class="py-6">
                <div class="max-w-full mx-auto px-4 sm:px-6 md:px-8 relative">
                    {{ $slot }}

                    {{-- Shared Components --}}
                    <livewire:live-night-audit />
                    <livewire:live-user-password-change />

                    {{-- Notifaction Toaster --}}
                    <x-success-notification />
                    <x-failure-notification />
                </div>
            </div>
        </main>
        {{-- End of Main Content --}}


    </div>
    {{-- End of Right Side Content --}}
</div>
