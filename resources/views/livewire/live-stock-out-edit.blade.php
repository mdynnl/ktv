<x-modal wire:model="showStockoutEditForm" size="lg">
    @if ($showStockoutEditForm)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Edit Stockout
            </h1>
        </x-slot>

        <form wire:submit.prevent="update" class="space-y-4">
            <div class="grid grid-cols-1 gap-x-6">
                <div class="space-y-8 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-1">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <x-form-datepicker-comp class="sm:col-span-2" wire:model.defer="stock_out_date" label="Stockout Date"
                                                    for="stock_out_date" />

                            <x-form-select-comp class="col-span-2" wire:model.defer="item_id" :options="$items"
                                                label="Items*"
                                                optionValue="id"
                                                optionDisplay="item_name"
                                                for="item_id" />

                            <x-form-select-comp class="col-span-2" wire:model.defer="stock_out_type_id" :options="$stockOutTypes"
                                                label="Stockout Types*"
                                                optionValue="id"
                                                optionDisplay="stock_out_type_name"
                                                for="stock_out_type_id" />

                            <x-form-input-comp class="col-span-2" wire:model.lazy="qty" label="Qty*"
                                               for="qty"
                                               type="text" />

                            <x-form-input-comp class="col-span-2" wire:model.lazy="price" label="Cost*"
                                               for="price"
                                               type="text" />


                            <x-display-info-comp class="col-span-2" label="Amount"
                                                 displayValue="{{ number_format($qty * $price, 0, '.', ',') }}" />

                            <x-form-textarea-comp class="sm:col-span-6" wire:model.defer="remark" label="Remark" for="remark"
                                                  rows="3"
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
    @endif
</x-modal>
