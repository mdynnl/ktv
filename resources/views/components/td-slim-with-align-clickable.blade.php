<td

    {{ $attributes->merge(['align', 'wire']) }}
    @class([
        'cursor-pointer text-gray-900 whitespace-nowrap border-b border-gray-200 py-2  text-sm text-gray-500 sm:table-cell',
        'pl-4 pr-3' => $align == 'left',
        'px-3' => $align == 'center',
        'pr-4 pl-3' => $align == 'right',
    ])>
    {{ $slot }}
</td>
