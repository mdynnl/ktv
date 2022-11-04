<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- <x-users-page-links /> --}}
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        <div class="flex items-center space-x-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 sr-only">Search</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                  clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model="search" type="text" name="search" id="search"
                           class="focus:ring-primary focus:border-primary block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                           placeholder="Search...">
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <p>
                    <span class="text-gray-500 text-sm">Service Staff Rate:</span>
                    <span>{{ number_format($serviceStaffRate, 0, '.', ',') }}</span>
                </p>
                <p>
                    <span class="text-gray-500 text-sm">Commission:</span>
                    <span>{{ number_format($serviceStaffCommissionRate, 0, '.', ',') }}</span>
                </p>
                @can('edit service staff')
                    <button type="button" wire:click="$emit('editStaffRate')"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                        Edit Rate
                    </button>
                @endcan

                {{-- <button wire:click="$emit('editStaffRate')" type="button"
                        class="mr-6 inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                    Edit Rate
                </button> --}}
            </div>
        </div>
        <div class="sm:ml-16 sm:flex-none">
            @can('add service staff')
                <button type="button" wire:click="$emit('createServiceStaff')"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add Service Staff
                </button>
            @endcan

        </div>
    </x-content-header-section>

    <x-sticky-table-wrapper>

        <thead class="bg-gray-50">
            <tr class="divide-x">
                {{-- <x-th width="80px">Sr. No</x-th> --}}
                <x-th-not-sticky width="80px">Sr. No</x-th-not-sticky>
                <x-th-not-sticky>Name</x-th-not-sticky>
                <x-th-not-sticky>Nick Name</x-th-not-sticky>
                <x-th-not-sticky>NRC No</x-th-not-sticky>
                <x-th-not-sticky>DOB</x-th-not-sticky>
                <x-th-not-sticky>Phone</x-th-not-sticky>
                <x-th-not-sticky>Address</x-th-not-sticky>
                <x-th-not-sticky>Status</x-th-not-sticky>
                <x-th-not-sticky>
                    <span class="sr-only">Edit</span>
                </x-th-not-sticky>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($staffs as $index => $user)
                <tr class="divide-x">
                    <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                    <x-td-image imagePath="{!! $user->getImage !!}"
                                name="{{ $user->name_on_nrc }}" />
                    <x-td>{{ $user->nick_name }}</x-td>
                    <x-td>{{ $user->nrc }}</x-td>
                    <x-td>{{ $user->dob->format('Y-m-d') }}</x-td>
                    <x-td>{{ $user->phone }}</x-td>
                    <x-td>{{ $user->address }}</x-td>
                    <x-td-slim-with-align align="center">
                        @if ($user->isActive)
                            <span
                                  class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Active</span>
                        @else
                            <span
                                  class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                Inactive</span>
                        @endif
                    </x-td-slim-with-align>
                    <x-td class="w-32">
                        <div class="inline-flex space-x-3 items-center">
                            @can('update', $user)
                                <button type="button" wire:click="$emit('editServiceStaff', {{ $user->id }})"
                                        class="text-primary hover:text-blue-900">Edit</button>
                            @endcan

                            @can('delete', $user)
                                <button type="button" wire:click="$emit('deleteServiceStaff', {{ $user->id }})"
                                        class="text-primary hover:text-blue-900">Delete</button>
                            @endcan
                        </div>
                    </x-td>
                </tr>
            @endforeach
        </tbody>
    </x-sticky-table-wrapper>

    {{-- <x-guest-view-modal :reqGuest="$reqGuest"></x-guest-view-modal> --}}

    {{-- <livewire:live-guest-create wire:key="create-guest-component" /> --}}
    <livewire:live-service-staff-create />
    <livewire:live-service-staff-edit />
    <livewire:live-service-staff-delete />
    <livewire:live-service-staff-rate-edit />


</x-page-layout>
