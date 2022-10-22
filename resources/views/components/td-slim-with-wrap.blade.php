<td
    {{ $attributes->merge([
        'class' => 'text-gray-900 border-b border-gray-200 pr-3 pl-4 py-2 sm:pl-6  text-sm text-gray-500 sm:table-cell',
        'align',
    ]) }}>
    {{ $slot }}
</td>
