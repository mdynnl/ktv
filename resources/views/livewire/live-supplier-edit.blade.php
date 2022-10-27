<x-modal wire:model="showSupplierEditForm" size="md2">
    @isset($supplier)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit {{ $supplier->supplier_name }}
            </h1>
        </x-slot>

        <form wire:submit.prevent="update" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-input-comp class="col-span-3" wire:model.defer="supplier.supplier_name"
                                               label="Supplier Name*"
                                               for="supplier.supplier_name"
                                               type="text" />

                            <x-form-input-comp class="col-span-3" wire:model.defer="supplier.contact_person"
                                               label="Contact Person"
                                               for="supplier.contact_person"
                                               type="text" />

                            <x-form-input-comp class="col-span-3" wire:model.defer="supplier.phone"
                                               label="Phone"
                                               for="supplier.phone"
                                               type="tel" />

                            <x-form-input-comp class="col-span-3" wire:model.defer="supplier.email"
                                               label="Email"
                                               for="supplier.email"
                                               type="email" />
                            {{-- <x-form-input-comp class="col-span-1" wire:model.defer="supplier.discount"
                                               label="Discount %"
                                               for="supplier.discount"
                                               type="text" /> --}}
                            <x-form-textarea-comp class="col-span-6" wire:model.defer="supplier.address"
                                                  label="Address"
                                                  rows="2"
                                                  for="supplier.address"
                                                  type="email" />

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
