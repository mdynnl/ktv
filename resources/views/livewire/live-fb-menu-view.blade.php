<x-page-layout>
    <x-slot:staticSidebarContent>
        <x-fnb-page-links />
    </x-slot:staticSidebarContent>


    <x-content-header-section>
        <div class="flex items-center justify-start space-x-3 w-full">
            <div class="flex items-center space-x-3">
                <span>Category:</span>
                <span class="isolate inline-flex rounded-md shadow-sm">
                    @foreach ($categories as $category)
                        <button type="button"
                                wire:click="$set('selectedCategoryId', {{ $category->id }})"
                                @class([
                                    'relative inline-flex items-center rounded-l-md  border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                        $loop->first,
                                    'relative -ml-px inline-flex items-center border border-gray-300 px-4 py-2 text-sm font-medium focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                        !$loop->first || $loop->last,
                                    'relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 focus:z-10 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary' =>
                                        $loop->last,
                                    'bg-primary text-white hover:bg-blue-900' =>
                                        $selectedCategoryId == $category->id,
                                    'bg-white text-gray-700 hover:bg-gray-50' =>
                                        $selectedCategoryId != $category->id,
                                ])>
                            {{ $category->food_category_name }}
                        </button>
                    @endforeach
                </span>
            </div>
        </div>
    </x-content-header-section>


    <div class="grid grid-cols-7 gap-8">
        <div class="col-span-3 relative">
            <x-sticky-table-wrapper>
                <thead class="bg-gray-50">
                    <tr class="divide-x">
                        <x-th width="80px">Sr. No</x-th>
                        <x-th>Food & Beverage Type</x-th>
                        <x-th width="150px">
                            @can('add food and beverage')
                                <button wire:click="$emit('createFoodType')" type="button"
                                        class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                    Add New
                                </button>
                            @endcan
                        </x-th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($foodTypes as $index => $type)
                        <tr
                            class="divide-x bg-white text-gray-900">
                            <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                            <x-td>{{ $type->food_type_name }}</x-td>
                            <x-td>
                                <div class="inline-flex space-x-3 items-center">
                                    <button type="button" wire:click="$set('selectedTypeId', {{ $type->id }})"
                                            @class([
                                                'inline-flex items-center rounded border border-transparent px-2.5 py-1.5 text-xs',
                                                'bg-primary text-white' => $type->id == $selectedTypeId,
                                                'text-primary' => $type->id != $selectedTypeId,
                                            ])>Select</button>

                                    @can('edit food and beverage')
                                        <button type="button" wire:click="$emit('editFoodType', {{ $type->id }})"
                                                class="text-primary hover:text-blue-900">Edit</button>
                                    @endcan

                                    @can('delete food and beverage')
                                        <button type="button" wire:click="$emit('deleteFoodType', {{ $type->id }})"
                                                class="text-primary hover:text-blue-900">Delete</button>
                                    @endcan
                                </div>
                            </x-td>
                        </tr>
                    @endforeach
                </tbody>
            </x-sticky-table-wrapper>

        </div>

        <div class="col-span-4 relative">
            <x-sticky-table-wrapper>
                <thead class="bg-gray-50">
                    <tr class="divide-x">
                        <x-th width="80px">Sr. No</x-th>
                        <x-th>Food & Beverage</x-th>
                        <x-th width="150px">Type</x-th>
                        <x-th align="center" width="150px">Price</x-th>
                        <x-th align="center" width="150px">Cost</x-th>
                        <x-th>
                            @can('add food and beverage')
                                <button wire:click="$emit('createFood', {{ $selectedTypeId }})" type="button"
                                        class="inline-flex items-center rounded border border-transparent bg-primary px-2.5 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none">
                                    Add New
                                </button>
                            @endcan
                        </x-th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($foods as $index => $food)
                        <tr class="divide-x">
                            <x-td-slim-with-align align="center">{{ $index + 1 }}</x-td-slim-with-align>
                            <x-td-image imagePath="{!! $food->getImage !!}"
                                        name="{{ $food->food_name }}" />
                            <x-td>{{ $food->foodType->food_type_name }}</x-td>

                            <x-td-slim-with-align align="right">{{ number_format($food->price, 0, '.', ',') }}</x-td-slim-with-align>
                            <x-td-slim-with-align align="right">{{ number_format($food->food_cost, 0, '.', ',') }}</x-td-slim-with-align>
                            {{-- <x-td>{{ $food->price }}</x-td> --}}
                            <x-td width="150px">
                                <div class="inline-flex space-x-3 items-center">
                                    @can('edit food and beverage')
                                        <button type="button" wire:click="$emit('editFood', {{ $food->id }})"
                                                class="text-primary hover:text-blue-900">Edit</button>
                                    @endcan
                                    @can('delete food and beverage')
                                        <button type="button" wire:click="$emit('deleteFood', {{ $food->id }})"
                                                class="text-primary hover:text-blue-900">Delete</button>
                                    @endcan


                                    @can('edit food and beverage')
                                        @if ($food->recipes->count() > 0)
                                            <button type="button"
                                                    wire:click="$emit('createRecipe', {{ $food->id }}, {{ true }})"
                                                    class="text-primary hover:text-blue-900">Edit Recipe</button>
                                        @else
                                            <button type="button" wire:click="$emit('createRecipe', {{ $food->id }})"
                                                    class="text-primary hover:text-blue-900">Add Recipe</button>
                                        @endif
                                    @endcan
                                </div>
                            </x-td>
                        </tr>
                    @endforeach
                </tbody>
            </x-sticky-table-wrapper>
        </div>
    </div>

    <livewire:live-food-type-create />
    <livewire:live-food-type-edit />
    <livewire:live-food-type-delete />

    <livewire:live-food-create />
    <livewire:live-food-edit />
    <livewire:live-food-delete />


    <livewire:live-recipe-create />
</x-page-layout>
