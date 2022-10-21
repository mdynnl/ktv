@props(['align' => 'left'])
<th
    @class([
        'whitespace-nowrap sticky top-0 z-10 border-b border-gray-300 bg-gray-50 py-3.5  text-sm font-semibold text-gray-900 ',
        'px-4 sm:px-6 text-center' => $align == 'center',
        'pl-4 sm:pl-6 pr-3 text-left' => $align == 'left',
    ])
    {{ $attributes->merge(['width']) }}
    scope="col">
    {{ $slot }}
</th>
