<th scope="col"
    {{ $attributes->merge([
        'class' =>
            'whitespace-nowrap sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6',
        'align',
    ]) }}>
    {{ $slot }}
</th>
