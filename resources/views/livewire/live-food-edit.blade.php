<x-modal wire:model="showFoodEditForm" size="md">
    @isset($food)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit {{ $food->food_name }}
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-file-input-comp class="col-span-6" wire:model="image" label="Food Image" for="image">
                                @if ($image)
                                    <x-slot name="preview">
                                        <img class="h-16 w-16 object-cover rounded-full"
                                             src="{{ $image->temporaryUrl() }}"
                                             alt="food image" />
                                    </x-slot>
                                @elseif($food->food_image)
                                    <x-slot name="preview">
                                        <img class="h-16 w-16 object-cover rounded-full"
                                             src="{!! $food->getImage !!}"
                                             alt="food image" />
                                    </x-slot>
                                @endif
                            </x-form-file-input-comp>
                            <x-form-select-comp class="col-span-2" label="Category*" wire:model="selectedFoodCategory"
                                                :options="$foodCategories"
                                                for="selectedFoodCategory"
                                                optionValue="id" optionDisplay="food_category_name" />

                            <x-form-select-comp class="col-span-4" label="Food Type*" wire:model="food.food_type_id"
                                                :options="$foodTypes"
                                                for="food.food_type_id"
                                                optionValue="id" optionDisplay="food_type_name" />

                            <x-form-input-comp class="col-span-4" wire:model="food.food_name"
                                               label="Food & Beverage Name*"
                                               for="food.food_name"
                                               type="text" />

                            <x-form-input-comp class="col-span-2" wire:model="food.price"
                                               label="Price*"
                                               for="food.price"
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
            <button type="submit" wire:click="update"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Update
            </button>
        </x-slot>
    @endisset
</x-modal>
