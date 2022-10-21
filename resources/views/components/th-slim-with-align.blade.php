<th scope="col"
    {{ $attributes->merge(['align', 'width']) }}
    @class([
        'whitespace-nowrap sticky top-0 z-10 border-b border-gray-300  py-2 bg-gray-50 text-sm font-semibold text-gray-900',
        'pl-4 pr-3' => $align == 'left',
        'px-3' => $align == 'center',
        'pr-4 pl-3' => $align == 'right',
    ])>
    {{ $slot }}
</th>
