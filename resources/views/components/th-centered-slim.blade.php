<th scope="col"
    {{ $attributes->merge([
        'class' =>
            'whitespace-nowrap sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-2 px-3 text-center text-sm font-semibold text-gray-900',
    ]) }}>
    {{ $slot }}
</th>
