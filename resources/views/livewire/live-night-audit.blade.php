<x-modal wire:model="showNightAuditConfirmModal" size="md">
    @isset($showNightAuditConfirmModal)
        <x-slot name="modalHeader">
            <h1 class="text-2xl font-semibold">
                Run Audit
            </h1>
        </x-slot>

        <div class="text-gray-700">
            <p class="text-base font-semibold">
                Your current operation date is {{ $operationDate }}.
            </p>
            <p class="text-sm max-w-xs mt-1">
                Are you sure you want to run audit? <br> This action will update the
                operation date to the latest.
            </p>
        </div>

        <x-slot name="modalAction">
            <button wire:click="run"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Run
            </button>
        </x-slot>
    @endisset
</x-modal>
