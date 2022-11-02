<x-modal wire:model="showRecipeCreateModal" size="xxl" cancelButtonLabel="Close">
    @isset($food)
        <x-slot name="modalHeader">
            <div>
                <h1 class="text-2xl font-semibold">Create Recipe for {{ $food->food_name }}</h1>
            </div>
        </x-slot>


        <div class="grid grid-cols-2 gap-x-8">
            <div class="col-span-1">
                <div class="grid grid-cols-2 gap-x-3 mb-5">
                    <x-table-filter-input class="col-span-1" wire:model="search" placeholder="Search Items..." />
                </div>

                <div class="h-96 border overflow-y-auto relative rounded-md overflow-hidden mb-3">
                    <table class="min-w-full border-separate " style="border-spacing: 0">
                        <thead class="bg-gray-50">
                            <tr class="divide-x">
                                <x-th-slim></x-th-slim>
                                <x-th-slim-with-align align="left">Item</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Unit</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Unit Price</x-th-slim-with-align>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($items as $key => $item)
                                <tr class="divide-x">
                                    <x-td-slim-checkbox>
                                        <x-inline-checkbox-without-label wire:key="{{ $item->id }}"
                                                                         wire:model="selectedItems"
                                                                         value="{{ $item->id }}" />
                                    </x-td-slim-checkbox>
                                    <x-td-slim-with-align align="left">{{ ucwords($item->item_name) }}</x-td-slim-with-align>
                                    <x-td-slim-with-align align="center">{{ ucwords($item->recipe_unit) }}</x-td-slim-with-align>
                                    <x-td-slim-with-align align="right">{{ $item->recipe_price }}</x-td-slim-with-align>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    <button wire:click="addToRecipeItems" type="button"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Add Selected
                    </button>
                </div>
            </div>

            <div class="col-span-1">
                <div class="flex justify-end mb-5">
                    <button wire:click="showLoadRecipeModal" type="button"
                            class="inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                        Load Recipe
                    </button>
                </div>

                <div class="h-96 border overflow-y-auto relative rounded-md overflow-hidden mb-3">
                    <table class="min-w-full border-separate " style="border-spacing: 0">
                        <thead class="bg-gray-50">
                            <tr class="divide-x">
                                <x-th-slim-with-align align="left">Item</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Unit</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Unit Price</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Qty</x-th-slim-with-align>
                                <x-th-slim-with-align align="center">Amount</x-th-slim-with-align>
                                <x-th-slim-with-align align="center"></x-th-slim-with-align>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($recipeItems as $index => $item)
                                <tr class="divide-x">
                                    <x-td-slim-with-align align="left">{{ ucwords($item['item_name']) }}</x-td-slim-with-align>
                                    <x-td-slim-with-align align="center">{{ ucwords($item['recipe_unit']) }}</x-td-slim-with-align>
                                    <x-td-slim-with-align align="center">{{ $item['recipe_price'] }}</x-td-slim-with-align>
                                    <x-td-slim-with-align-clickable align="center" wire:click="showChangeQtyInput('{{ $index }}')">
                                        {{ $item['qty'] }}</x-td-slim-with-align-clickable>
                                    <x-td-slim-with-align align="right">{{ number_format($item['amount'], 0, '.', ',') }}
                                    </x-td-slim-with-align>
                                    <x-td-slim-checkbox>
                                        <button wire:click="deleteRecipeItem('{{ $index }}')"
                                                class="hover:bg-gray-200 p-1 rounded-md">

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                 class="h-5 text-gray-500 w-5">
                                                <path fill-rule="evenodd"
                                                      d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-td-slim-checkbox>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end">
                    <div>
                        @php
                            $total = 0;
                            foreach ($recipeItems as $item) {
                                $total += $item['amount'];
                            }
                        @endphp
                        <span class="font-semibold mr-2 text-gray-600 text-sm">Total Cost</span>
                        <span
                              class="bg-gray-200 border border-transparent font-semibold inline-flex justify-end px-4 py-2 rounded-md shadow-sm text-gray-600 text-sm w-28">{{ number_format($total, 0, '.', ',') }}</span>
                    </div>
                </div>
            </div>
        </div>


        <x-slot name="modalAction">
            <button {{ $isDirty ? '' : 'disabled' }} type="button" wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md disabled:text-gray-400 disabled:bg-gray-300 enabled:text-white enabled:bg-primary enabled:hover:bg-blue-900 focus:outline-none">
                {{ $hasRecipe ? 'Update' : 'Create' }}
            </button>
        </x-slot>
    @endisset


    {{-- Qty edit modal --}}
    <div wire:key="1-qty-edit">
        <div x-data="{
            showQtyEditModal: @entangle('showQtyEditModal'),
        }">
            <div x-show="showQtyEditModal" x-cloak x-trap="showQtyEditModal" class="absolute grid inset-0 place-items-center z-10">
                <form wire:submit.prevent="updateQty" @click.outside="showQtyEditModal = false"
                      class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    <div class="bg-primary font-semibold px-4 py-3.5 text-white">
                        @isset($editingRecipeItem['item_name'])
                            Item: {{ $editingRecipeItem['item_name'] }}
                        @endisset
                    </div>
                    <div class="flex-1 px-4 py-5 text-sm">

                        <x-form-input-comp class="w-full" wire:model="editingRecipeQty" label="Qty" for="editingRecipeQty"
                                           type="text" />

                    </div>

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showQtyEditModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Change
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:key="2-delete-recipe-item">
        <div x-data="{
            showRecipeItemDeleteConfirmationModal: @entangle('showRecipeItemDeleteConfirmationModal'),
        }">
            <div x-show="showRecipeItemDeleteConfirmationModal" x-cloak x-trap="showRecipeItemDeleteConfirmationModal"
                 class="absolute grid inset-0 place-items-center z-10">
                <form wire:submit.prevent="updateQty" @click.outside="showRecipeItemDeleteConfirmationModal = false"
                      class="bg-white border flex flex-col max-w-sm rounded-lg w-full overflow-hidden">
                    <div class="flex-1 px-4 py-5 text-sm">

                        <div class="text-gray-700">
                            <p class="text-base font-semibold">
                                Are you sure you want to delete Recipe Item:
                                {{ isset($editingRecipeItem['item_name']) ? $editingRecipeItem['item_name'] : '' }}?
                            </p>
                            <p class="text-sm max-w-xs mt-1">
                                This action will delete the record from the database and is irreversible.
                            </p>
                        </div>
                    </div>

                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showRecipeItemDeleteConfirmationModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                No
                            </button>
                            <button type="button" wire:click="deleteDbRecipeItem"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Yes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Recipe Load Modal --}}
    <div wire:key="3-load-recipe">
        <div x-data="{
            showLoadRecipeModal: @entangle('showLoadRecipeModal'),
        }">
            <div
                 x-show="showLoadRecipeModal"
                 x-cloak
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-10"></div>
            <div x-show="showLoadRecipeModal" x-cloak x-trap="showLoadRecipeModal"
                 class="absolute grid inset-0 place-items-center z-10">
                <div @click.outside="showLoadRecipeModal = false"
                     class="bg-white border flex flex-col max-w-md rounded-lg w-full overflow-hidden">
                    @if ($showLoadRecipeModal)
                        <div class="flex-1 px-4 py-5 text-sm">
                            <x-table-filter-select-comp class="w-full" wire:model="selectedFoodId" for="selectedFoodId" :options="$foods"
                                                        optionValue="id"
                                                        optionDisplay="food_name" label="Select a Food" />

                            <div class="mt-6 h-96 border overflow-y-auto relative rounded-md overflow-hidden mb-3">
                                <table class="min-w-full border-separate " style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                        <tr class="divide-x">
                                            <x-th-slim></x-th-slim>
                                            <x-th-slim-with-align align="left">Item</x-th-slim-with-align>
                                            <x-th-slim-with-align align="center">Unit</x-th-slim-with-align>
                                            {{-- <x-th-slim-with-align align="center">Unit Price</x-th-slim-with-align> --}}
                                            <x-th-slim-with-align align="center">Qty</x-th-slim-with-align>
                                            {{-- <x-th-slim-with-align align="center">Amount</x-th-slim-with-align> --}}
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($selectedFoodRecipes as $key => $recipe)
                                            <tr class="divide-x">
                                                <x-td-slim-checkbox>
                                                    <x-inline-checkbox-without-label wire:key="{{ $recipe->id }}"
                                                                                     wire:model="selectedLoadedRecipeItems"
                                                                                     value="{{ $recipe->id }}" />
                                                </x-td-slim-checkbox>
                                                <x-td-slim-with-align align="left">{{ ucwords($recipe->item->item_name) }}
                                                </x-td-slim-with-align>
                                                <x-td-slim-with-align align="center">{{ ucwords($recipe->item->recipe_unit) }}
                                                </x-td-slim-with-align>
                                                {{-- <x-td-slim-with-align align="right">{{ $recipe->item->recipe_price }}
                                                </x-td-slim-with-align> --}}
                                                <x-td-slim-with-align align="center">{{ $recipe->qty }}
                                                </x-td-slim-with-align>
                                                {{-- <x-td-slim-with-align align="center">{{ $recipe->qty * $recipe->item->recipe_price }}
                                                </x-td-slim-with-align> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    @endif


                    <div class="py-3 bg-gray-200 px-6">
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            <button wire:click="$set('showLoadRecipeModal', false)" type="button"
                                    class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none">
                                Cancel
                            </button>
                            <button type="button" wire:click="loadRecipe"
                                    class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                Load Recipe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-modal>
