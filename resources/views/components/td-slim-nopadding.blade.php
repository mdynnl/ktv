<td
    {{ $attributes->merge([
        'class' => 'text-gray-900 whitespace-nowrap border-b border-gray-200  py-2 px-3 text-sm text-gray-500 sm:table-cell',
        'align',
    ]) }}>
    {{ $slot }}
</td>
