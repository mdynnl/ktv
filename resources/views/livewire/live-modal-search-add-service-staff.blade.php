<x-modal wire:model="showSearchAddServiceStaff" size="md2">
    @isset($staffs)
        <x-slot name="modalHeader">
            <div>
                <h1 class="text-2xl font-semibold">Search & Add Service Staff</h1>
            </div>
        </x-slot>

        <div class="h-full">
            <div class="flex flex-col h-full">
                <div class="px-6 flex-1">
                    <x-form-input-comp class="col-span-3" wire:model="search" label="Search"
                                       for="search"
                                       type="text" />
                    <div class="h-[400px] border overflow-y-scroll relative rounded-xl shadow-md mt-6">
                        <table class="min-w-full border-separate " style="border-spacing: 0">
                            <thead class="bg-gray-50">
                                <tr class="divide-x">
                                    <x-th-slim></x-th-slim>
                                    <x-th-slim>Id</x-th-slim>
                                    <x-th-slim>Name</x-th-slim>
                                    <x-th-slim>Phone</x-th-slim>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($staffs as $staff)
                                    <tr
                                        class="divide-x hover:bg-gray-200 transition-colors ease-out duration-150 cursor-pointer">
                                        <x-td-slim-checkbox>
                                            <x-inline-checkbox-without-label wire:key="{{ $staff->id }}"
                                                                             wire:model="selectedStaff"
                                                                             value="{{ $staff->id }}" />
                                        </x-td-slim-checkbox>
                                        <x-td-slim>{{ $staff->id }}</x-td-slim>
                                        <x-td-slim>{{ $staff->name }}</x-td-slim>
                                        <x-td-slim>{{ $staff->phone }}</x-td-slim>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <x-slot name="modalAction">
            <button wire:click="addToCallersList" type="button"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">Add
                Selected Guest</button>
        </x-slot>
    @endisset
</x-modal>
