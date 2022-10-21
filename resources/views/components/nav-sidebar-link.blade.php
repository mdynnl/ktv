@props(['active'])

@php
$classes = $active ?? false ? 'inline-flex items-center px-4 py-2 bg-white rounded-md w-full border-primary text-sm font-medium leading-5 text-primary focus:outline-none focus:border-blue-700 transition duration-150 ease-in-out' : 'hover:border hover:border-white border border-transparent duration-150 ease-in-out font-medium inline-flex items-center leading-5 px-4 py-2 rounded-md text-sm text-white transition w-full';
// : 'bg-gray-300  border-primary duration-150 ease-in-out focus:border-blue-700 focus:outline-none font-medium inline-flex items-center leading-5 px-4 py-2 rounded-md text-sm text-primary transition w-full';
@endphp
{{-- <span class="border"></span> --}}

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
