<x-page-layout>
    <x-slot:staticSidebarContent>
        {{-- <x-users-page-links /> --}}
    </x-slot:staticSidebarContent>

    <x-content-header-section>
        {{-- <div>
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
        </div> --}}
        {{-- <div class="sm:ml-16 sm:flex-none">
            <a href="{{ route('service-staff.create') }}"
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                Add Room
            </a>
        </div> --}}
    </x-content-header-section>

    <div class="grid grid-cols-6 gap-8">
        <div class="col-span-3 relative">
            <x-sticky-table-wrapper>
                <thead class="bg-gray-50">
                    <tr class="divide-x">
                        <x-th width="80px">Sr. No</x-th>
                        <x-th>Room Type</x-th>
                        <x-th>Room Rate</x-th>
                        <x-th width="150px">
                            <button wire:click="$emit('createRoomType')" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Add Room Type
                            </button>
                        </x-th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($roomTypes as $index => $type)
                        <tr
                            class="divide-x bg-white text-gray-900">
                            <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                            <x-td>{{ $type->room_type_name }}</x-td>
                            <x-td>{{ $type->room_rate }}</x-td>
                            <x-td>
                                <div class="inline-flex space-x-3 items-center">
                                    <button type="button" wire:click="$set('selectedTypeId', {{ $type->id }})"
                                            @class([
                                                'inline-flex items-center rounded border border-transparent px-2.5 py-1.5 text-xs',
                                                'bg-primary text-white' => $type->id == $selectedTypeId,
                                                'text-primary' => $type->id != $selectedTypeId,
                                            ])>Select</button>

                                    <button type="button" wire:click="$emit('editRoomType', {{ $type->id }})"
                                            class="text-primary hover:text-blue-900">Edit</button>
                                    <button type="button" wire:click="$emit('deleteRoomType', {{ $type->id }})"
                                            class="text-primary hover:text-blue-900">Delete</button>
                                </div>
                            </x-td>
                        </tr>
                    @endforeach
                </tbody>
            </x-sticky-table-wrapper>

        </div>

        <div class="col-span-3 relative">
            <x-sticky-table-wrapper>
                <thead class="bg-gray-50">
                    <tr class="divide-x">
                        <x-th width="80px">Sr. No</x-th>
                        <x-th width="200px">Room</x-th>
                        <x-th>Type</x-th>
                        {{-- <x-th>Price</x-th> --}}
                        <x-th>
                            <button wire:click="$emit('createRoom', {{ $selectedTypeId }})" type="button"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Add Room
                            </button>
                        </x-th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($rooms as $index => $room)
                        <tr class="divide-x">
                            <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                            <x-td>{{ $room->room_no }}</x-td>
                            <x-td>{{ $room->type->room_type_name }}</x-td>
                            <x-td width="150px">
                                <div class="inline-flex space-x-3 items-center">
                                    <button type="button" wire:click="$emit('editRoom', {{ $room->id }})"
                                            class="text-primary hover:text-blue-900">Edit</button>
                                    <button type="button" wire:click="$emit('deleteRoom', {{ $room->id }})"
                                            class="text-primary hover:text-blue-900">Delete</button>
                                </div>
                            </x-td>
                        </tr>
                    @endforeach
                </tbody>
            </x-sticky-table-wrapper>
        </div>
    </div>

    <livewire:live-room-type-create />
    <livewire:live-room-type-edit />
    <livewire:live-room-type-delete />


    <livewire:live-room-create />
    <livewire:live-room-edit />
    <livewire:live-room-delete />
</x-page-layout>
