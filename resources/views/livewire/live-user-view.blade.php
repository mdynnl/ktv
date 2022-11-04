<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-users-page-links />
    </x-slot:staticSidebarContent>

    <x-content-header-section>
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
        <div class="sm:ml-16 sm:flex-none">
            @can('create', App\Models\User::class)
                <button type="button"
                        wire:click="$emit('createUser')"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto">
                    Add User
                </button>
            @endcan

        </div>
    </x-content-header-section>

    <x-table-wrapper>
        <table class="min-w-full border-separate mb-8" style="border-collapse: collapse">
            <thead class="bg-gray-50">
                <tr class="divide-x">
                    <x-th-not-sticky width="80px">Sr. No</x-th-not-sticky>
                    <x-th-not-sticky>Name</x-th-not-sticky>
                    <x-th-not-sticky>Role</x-th-not-sticky>
                    <x-th-not-sticky>Username</x-th-not-sticky>
                    <x-th-not-sticky>Email</x-th-not-sticky>
                    <x-th-not-sticky>Phone</x-th-not-sticky>
                    <x-th-not-sticky>
                        <span class="sr-only">Edit</span>
                    </x-th-not-sticky>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($users as $index => $user)
                    <tr class="divide-x">
                        <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                        <x-td>{{ $user->name }}</x-td>
                        <x-td>{{ $user->roleName() }}</x-td>
                        <x-td>{{ $user->username }}</x-td>
                        <x-td>{{ $user->email }}</x-td>
                        <x-td>{{ $user->phone }}</x-td>
                        <x-td class="w-52">
                            <div class="inline-flex space-x-3 items-center">
                                @can('viewAny', App\Models\User::class)
                                    <button type="button" wire:click="$emit('editUser', '{{ $user->id }}')"
                                            class="text-primary hover:text-blue-900">Edit</button>
                                @endcan
                                @can('delete', $user)
                                    <button type="button" wire:click="$emit('deleteUser', '{{ $user->id }}')"
                                            class="text-primary hover:text-blue-900">Delete</button>
                                @endcan
                            </div>
                        </x-td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-table-wrapper>

    {{-- <x-guest-view-modal :reqGuest="$reqGuest"></x-guest-view-modal> --}}

    {{-- <livewire:live-guest-create wire:key="create-guest-component" /> --}}

    <livewire:live-user-create />
    <livewire:live-user-edit />
    <livewire:live-user-delete />
</x-page-layout>
