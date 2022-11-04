<x-modal wire:model="showExpenseEditForm" size="lg">
    @if ($showExpenseEditForm)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit Expense
            </h1>
        </x-slot>

        <form wire:submit.prevent="update" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-8">

                            <x-form-datepicker-comp class="sm:col-span-2" wire:model.defer="expense_date" label="Expense Date*"
                                                    for="expense_date" />

                            <x-form-select-comp class="col-span-2" wire:model.defer="expense_type_id"
                                                :options="$expenseTypes"
                                                optionValue="id"
                                                optionDisplay="expense_type_name"
                                                label="Expense Types*"
                                                for="expense_type_id">
                                <x-slot name="labelButton">
                                    <button wire:click="$emit('createExpenseTypes')"
                                            type="button"
                                            class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>
                            </x-form-select-comp>


                            <x-form-input-comp class="col-span-2" wire:model.defer="qty" label="Qty"
                                               for="qty"
                                               type="text" />

                            <x-form-input-comp class="col-span-2" wire:model.defer="price" label="Price*"
                                               for="price"
                                               type="text" />

                            <x-form-textarea-comp class="sm:col-span-8" wire:model.defer="description" label="Description" for="description"
                                                  rows="3"
                                                  type="text" />

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
    @endif
</x-modal>
