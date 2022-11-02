<x-modal wire:model="showStockoutDeleteModal" size="md">
    @if ($showStockoutDeleteModal)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Delete Stockout ID: {{ $stockout->id }}
            </h1>
        </x-slot>

        <div class="text-gray-700">
            <p class="text-base font-semibold">
                Are you sure you want to delete this stockout record?
            </p>
            <p class="text-sm max-w-xs mt-1">
                This action will delete the record from the database and is irreversible.
            </p>
        </div>

        <x-slot name="modalAction">
            <button wire:click="delete"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Delete
            </button>
        </x-slot>
    @endif
</x-modal>
