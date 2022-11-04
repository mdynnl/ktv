<td
    {{ $attributes->merge(['align']) }}
    @class([
        'text-gray-900 whitespace-nowrap py-2 text-sm text-gray-500 sm:table-cell',
        'pl-4 pr-3' => $align == 'left',
        'px-3' => $align == 'center',
        'pr-4 pl-3' => $align == 'right',
    ])>
    {{ $slot }}
</td>
