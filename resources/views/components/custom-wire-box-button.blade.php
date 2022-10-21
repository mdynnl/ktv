<button {{ $attributes->wire('click') }} {{ $isDisabled ? 'disabled' : '' }}
        type="button"
        class="disabled:opacity-75 disabled:bg-gray-400 inline-flex items-center rounded-md border border-transparent enabled:bg-primary px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm enabled:hover:bg-blue-900 focus:outline-none enabled:focus:ring-2 enabled:focus:ring-primary enabled:focus:ring-offset-2">
    <span>{{ $label }}</span>
</button>
