<x-modal wire:model="showSearchAddServiceStaff" size="md2">
    @if ($showSearchAddServiceStaff)
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
                                    <x-th-slim>Service Staffs</x-th-slim>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($staffs as $staff)
                                    <tr
                                        wire:key="{{ $staff->id . '-' . $staff->nick_name }}"
                                        class="divide-x">
                                        <x-td-slim-checkbox>

                                            <x-inline-checkbox-with-label-image
                                                                                for="{{ $staff->id }}"
                                                                                :isDisabled="false"
                                                                                wire:model="selectedStaff"
                                                                                image="{!! $staff->getImage !!}"
                                                                                label="{{ $staff->nick_name }}"
                                                                                value="{{ $staff->id }}" />
                                        </x-td-slim-checkbox>
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
                Selected Staff</button>
        </x-slot>
    @endif
</x-modal>
