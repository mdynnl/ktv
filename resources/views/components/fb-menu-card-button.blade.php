<button type="button" {{ $attributes->wire('click') }}
        @class([
            'px-2 border rounded-md h-12 max-w-[80px] flex items-center justify-center w-full text-xs  transition-colors duration-150',
            'bg-primary text-white hover:bg-blue-900' => $active,
            'hover:bg-gray-200' => !$active,
        ])>
    {{ $label }}
</button>
