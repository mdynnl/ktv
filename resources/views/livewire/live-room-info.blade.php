<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-desktop-sidebar-section title="Status">
            <fieldset class="space-y-5">
                <x-inline-checkbox-with-values wire:key="thisDepartureCount" wire:model="roomStatuses" label="Departure"
                                               :displayValue="$departureCount"
                                               value="1" for="departure" />
                <x-inline-checkbox-with-values wire:key="thisOccupyCount" wire:model="roomStatuses" label="Occupy" :displayValue="$occupyCount"
                                               value="2" for="occupy" />
                <x-inline-checkbox-with-values wire:key="thisVaccantCount" wire:model="roomStatuses" label="Vacant"
                                               :displayValue="$vacantCount"
                                               value="0" for="vacant" />
            </fieldset>
        </x-desktop-sidebar-section>

        <x-desktop-sidebar-section title="Type">
            <fieldset class="space-y-5">
                @foreach ($roomTypesWithCounts as $roomType)
                    <x-inline-checkbox-with-values wire:key="type-checkbox-{{ $roomType->id }}"
                                                   wire:model="typesIdForCheckbox"
                                                   label="{{ $roomType->room_type_name }}" for="{{ $roomType->room_type_name }}"
                                                   displayValue="{{ $roomType->count }}"
                                                   value="{{ $roomType->id }}" />
                @endforeach
            </fieldset>
        </x-desktop-sidebar-section>


    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center space-x-3">
            <span>View by:</span>
            <span class="isolate inline-flex rounded-md shadow-sm">
                <button type="button"
                        wire:click="$set('viewBy', 'type')"
                        @class([
                            'relative inline-flex items-center rounded-l-md border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary',
                            'bg-primary text-white hover:bg-blue-900' => $viewBy == 'type',
                            'bg-white text-gray-700 hover:bg-gray-50' => $viewBy != 'type',
                        ])>
                    Type
                </button>
                <button type="button"
                        wire:click="$set('viewBy', 'status')"
                        @class([
                            'relative -ml-px inline-flex items-center border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary',
                            'bg-primary text-white hover:bg-blue-900' => $viewBy == 'status',
                            'bg-white text-gray-700 hover:bg-gray-50' => $viewBy != 'status',
                        ])>
                    Status
                </button>
                <button type="button"
                        wire:click="$set('viewBy', 'all')"
                        @class([
                            'relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary',
                            'bg-primary text-white hover:bg-blue-900' => $viewBy == 'all',
                            'bg-white text-gray-700 hover:bg-gray-50' => $viewBy != 'all',
                        ])>
                    All
                </button>
            </span>
        </div>


        <div x-data="{
            showLegends: false,
        }" class="relative inline-block text-left">
            <div class="flex items-center">
                <button type="button"
                        @click="showLegends = !showLegends"
                        :class="showLegends ? 'bg-primary' : 'bg-gray-200'"
                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none "
                        role="switch" aria-checked="false" aria-labelledby="annual-billing-label">
                    <span aria-hidden="true"
                          :class="showLegends ? 'translate-x-5' : 'translate-x-0'"
                          class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                </button>
                <span class="ml-3" id="annual-billing-label">
                    <span class="text-sm font-medium text-gray-900">Toggle Legends</span>
                </span>
            </div>

            <div
                 x-show="showLegends"
                 @click.outside="showLegends = false"
                 x-cloak
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 z-[5] mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                 role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="px-6 py-4 flex items-start space-x-6" role="none">
                    <ul class="flex flex-col space-y-3">


                        <li class="flex items-center space-x-2">
                            <span class="p-3 rounded-md inline-flex bg-vacant"></span>
                            <span class="text-xs inline-flex text-gray-800">Vacant</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="p-3 rounded-md inline-flex bg-occupy"></span>
                            <span class="text-xs inline-flex text-gray-800">Occupy</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="p-3 rounded-md inline-flex bg-departure"></span>
                            <span class="text-xs inline-flex text-gray-800">Departure</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="p-3 rounded-md inline-flex bg-arrival"></span>
                            <span class="text-xs inline-flex text-gray-800">Paid</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="p-3 rounded-md inline-flex bg-red-400"></span>
                            <span class="text-xs inline-flex text-gray-800">Times Up</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-content-header-section>


    @isset($rooms)
        <div wire:poll.3000ms>
            @if ($viewBy == 'all')
                <section class="mb-16">
                    <header>
                        <h1 class="text-2xl font-semibold text-primary">All Rooms</h1>
                    </header>

                    <div class="flex flex-wrap gap-x-8 gap-y-8 mt-3">
                        @foreach ($rooms as $room)
                            <x-room-info-card :room="$room" />
                        @endforeach
                    </div>
                </section>
            @else
                @foreach ($rooms as $key => $items)
                    <section class="mb-16">
                        <header>
                            <h1 class="text-2xl font-semibold text-primary">{{ $key }}</h1>
                        </header>

                        <div class="flex flex-wrap gap-x-8 gap-y-8 mt-3">
                            @foreach ($items as $room)
                                <x-room-info-card :room="$room" />
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @endif
        </div>
    @endisset



    {{-- Room related Components --}}
    {{-- <livewire:live-view-transaction /> --}}
    <livewire:live-modal-add-transactions />
    <livewire:live-invoice-payment-folio-view />
    <livewire:live-modal-payment-form />
    {{-- <livewire:live-modal-add-housekeeping-items wire:key="modal-add-housekeeping-items" />
    <livewire:live-view-housekeeping-income wire:key="view-housekeeping-income" />
    <livewire:live-out-of-order-create wire:key="out-of-order-create" />
    <livewire:live-view-guest-list wire:key="view-guest-list" />
    <livewire:live-room-transfer wire:key="room-transfer" />
    <livewire:live-room-checkout /> --}}


    {{-- Shared Components --}}
    <livewire:live-walk-in />
    <livewire:live-inhouse-edit />
    <livewire:live-modal-search-add-service-staff />
    <livewire:live-modal-handle-fb-table-order />
    <livewire:live-room-transfer />

    {{-- <livewire:live-modal-search-create-guest wire:key="modal-search-create-guest-component" />
    <livewire:live-reservation-edit wire:key="edit-reservation-component" />
    <livewire:live-arrival-check-in wire:key="arrival-check-in-component" />
    <livewire:live-inhouse-edit wire:key="inhouse-edit-component" />
    <livewire:live-nationality-create wire:key="create-nationality-component" /> --}}
</x-page-layout>
