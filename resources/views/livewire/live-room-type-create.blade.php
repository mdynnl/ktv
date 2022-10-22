<x-modal wire:model="showRoomTypeCreateForm" size="md">
    @isset($roomType)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Add a Room Type
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-input-comp class="col-span-3" wire:model.defer="roomType.room_type_name"
                                               label="Room Type Name*"
                                               for="roomType.room_type_name"
                                               type="text" />
                            <x-form-input-comp class="col-span-3" wire:model.defer="roomType.room_rate"
                                               label="Room Type Rate*"
                                               for="roomType.room_rate"
                                               type="text" />


                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="modalAction">
            <button wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create
            </button>
        </x-slot>
    @endisset
</x-modal>
