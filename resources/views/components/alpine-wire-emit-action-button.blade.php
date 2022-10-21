<button x-on:click.stop="showActions = false; $wire.emit('{{ $event }}', {{ $actionId }})"
        {{ $isDisabled ? 'disabled' : '' }}
        type="button"
        class="block disabled:opacity-50 hover:bg-gray-100 disabled:hover:bg-transparent px-4 py-2 text-gray-700 text-left text-sm w-full">
    <span>{{ $label }}</span>
</button>
