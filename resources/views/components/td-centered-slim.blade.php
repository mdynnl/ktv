<td
    {{ $attributes->merge([
        'class' => 'text-gray-900 whitespace-nowrap border-b border-gray-200 px-3 py-2 text-sm text-gray-500 sm:table-cell',
    ]) }}>
    {{ $slot }}
</td>
