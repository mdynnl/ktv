<x-modal wire:model="showSearchAddItem" size="lg">
    @isset($items)
        <x-slot name="modalHeader">
            <div>
                <h1 class="text-2xl font-semibold">Add Item</h1>
            </div>
        </x-slot>

        <form wire:submit.prevent="create" class="grid gap-y-6 gap-x-4 grid-cols-7">

            <x-form-select-comp class="col-span-2" wire:model="item_id" :options="$items" optionValue="id"
                                isDisabled="{{ false }}"
                                optionDisplay="item_name" label="Select an Item*" for="item_id" />

            <x-form-disabled-comp class="col-span-1" wire:model.defer="recipe_unit" label="Recipe Unit"
                                  for="recipe_unit"
                                  type="text" />

            <x-form-input-comp class="col-span-1" wire:model.defer="invoice_unit" label="Invoice Unit*"
                               for="invoice_unit"
                               type="text" />

            <x-form-input-comp class="col-span-1" wire:model.defer="price" label="Price*"
                               for="price"
                               type="text" />

            <x-form-input-comp class="col-span-1" wire:model.defer="qty" label="Qty*"
                               for="qty"
                               type="text" />

            <x-form-input-comp class="col-span-1" wire:model.defer="recipe_qty" label="Recipe Qty*"
                               for="recipe_qty"
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
        </form>

        </div>


        <x-slot name="modalAction">
            <button wire:click="addToCallersList" type="button"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Add Item
            </button>
        </x-slot>
    @endisset
</x-modal>
