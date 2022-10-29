<x-modal wire:model="showServiceStaffRateEditForm" size="sm">
    @isset($serviceStaffRate)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit Service Staff Rate
            </h1>
        </x-slot>

        <form wire:submit.prevent="update" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-input-comp class="col-span-6" wire:model.defer="serviceStaffRate.service_staff_rate"
                                               label="Rate*"
                                               for="serviceStaffRate.service_staff_rate"
                                               type="text" />

                            <x-form-input-comp class="col-span-6" wire:model.defer="serviceStaffRate.service_staff_commission_rate"
                                               label="Commission*"
                                               for="serviceStaffRate.service_staff_commission_rate"
                                               type="text" />

                            {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <x-slot name="modalAction">
            <button type="submit" wire:click="update"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Update
            </button>
        </x-slot>
    @endisset
</x-modal>
