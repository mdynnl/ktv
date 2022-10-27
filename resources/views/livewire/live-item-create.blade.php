<x-modal wire:model="showItemCreateForm" size="md2">
    @isset($item)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Add an Item
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-8">
                            <x-form-input-comp class="col-span-4" wire:model.defer="item.item_name"
                                               label="Item Name*"
                                               for="item.item_name"
                                               type="text" />
                            <x-form-input-comp class="col-span-4" wire:model.defer="item.recipe_unit"
                                               label="Recipe Unit*"
                                               for="item.recipe_unit"
                                               type="text" />
                            <x-form-input-comp class="col-span-4" wire:model.defer="item.recipe_price"
                                               label="Recipe Price*"
                                               for="item.recipe_price"
                                               type="text" />
                            <x-form-input-comp class="col-span-2" wire:model.defer="item.reorder"
                                               label="Reorder*"
                                               for="item.reorder"
                                               type="number" />



                            <fieldset class="col-span-2 flex mt-6">
                                {{-- <div class="block font-medium text-gray-700 text-sm mb-1" aria-hidden="true">Stores*</div> --}}
                                <div class="flex items-center mt-2.5 space-x-6">
                                    <div class="relative flex items-start">
                                        <div class="flex h-5 items-center">
                                            <input wire:model="item.is_kitchen_item" id="is_kitchen_item"
                                                   value="1"
                                                   name="is_kitchen_item" type="checkbox"
                                                   class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_kitchen_item"
                                                   class="font-medium text-gray-700">Is Kitchen Item</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>



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
