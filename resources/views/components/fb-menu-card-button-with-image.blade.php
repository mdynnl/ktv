<button type="button" {{ $attributes->wire('click') }}
        @class([
            'w-44 h-20 px-2 py-2 flex space-x-3 border rounded-md text-xs transition-colors duration-150',
            'bg-primary text-white hover:bg-blue-900' => $active,
            'hover:bg-gray-200' => !$active,
        ])>
    <div class="flex h-full items-center">
        <img {{ $attributes->merge(['class' => 'h-10 w-10 rounded-md']) }}
             src="{{ $image }}"
             alt="">

    </div>
    <div class="flex flex-1 flex-col h-full items-start justify-center">
        <span class="text-left">{{ $label }}</span>
        <span>Price: {{ number_format($price, 0, '.', ',') }}</span>
    </div>
</button>
