<x-modal wire:model="showCustomerCreateForm" size="md2">
    @isset($customer)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Add a Customer
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-input-comp class="col-span-3" wire:model.defer="customer.customer_name"
                                               label="Name*"
                                               for="customer.customer_name"
                                               type="text" />
                            <x-form-input-comp class="col-span-3" wire:model.defer="customer.phone"
                                               label="Phone"
                                               for="customer.phone"
                                               type="tel" />
                            {{-- <x-form-input-comp class="col-span-1" wire:model.defer="customer.discount"
                                               label="Discount %"
                                               for="customer.discount"
                                               type="text" /> --}}
                            <x-form-textarea-comp class="col-span-6" wire:model.defer="customer.address"
                                                  label="Address"
                                                  rows="2"
                                                  for="customer.address"
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
            <button type="submit" wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create
            </button>
        </x-slot>
    @endisset
</x-modal>
