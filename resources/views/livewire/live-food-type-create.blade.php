<x-modal wire:model="showFoodTypeCreateForm" size="md">
    @isset($foodType)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Add a Food Type
            </h1>
        </x-slot>

        <form wire:submit.prevent="create" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <x-form-select-comp class="col-span-3" label="Category*" wire:model="foodType.food_category_id"
                                                :options="$foodCategories"
                                                for="foodType.food_category_id"
                                                optionValue="id" optionDisplay="food_category_name" />


                            <x-form-select-comp class="col-span-3" label="Print To*" wire:model="foodType.printer_type_id"
                                                :options="$printers"
                                                for="foodType.printer_type_id"
                                                optionValue="id" optionDisplay="printer_type" />

                            <x-form-input-comp class="col-span-4" wire:model="foodType.food_type_name"
                                               label="Type name*"
                                               for="foodType.food_type_name"
                                               type="text" />

                            <div class="col-span-2 flex flex-col justify-end">
                                <div class="flex items-end relative">
                                    <div class="flex h-5 items-center">
                                        <input wire:model="foodType.isPrintable" id="is-printable"
                                               aria-describedby="is-printable" name="is-printable" type="checkbox"
                                               class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is-printable" class="font-medium text-gray-700">Printable</label>
                                    </div>
                                </div>

                                <div class="flex items-center relative">
                                    <div class="flex h-5 items-center">
                                        <input wire:model="foodType.isFunctionMenu" id="is-function-menu"
                                               aria-describedby="is-function-menu" name="is-function-menu" type="checkbox"
                                               class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is-function-menu" class="font-medium text-gray-700">Function Menu</label>
                                    </div>
                                </div>

                                @error('foodType.isPrintable')
                                    <x-form-error-component message="{{ $message }}" />
                                @enderror
                                @error('foodType.isFunctionMenu')
                                    <x-form-error-component message="{{ $message }}" />
                                @enderror
                            </div>
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
            <button wire:click="create"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Create
            </button>
        </x-slot>
    @endisset
</x-modal>
