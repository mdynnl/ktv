<button
        {{ $attributes->merge(['type' => 'submit', 'class' => 'flex w-full justify-center rounded-md border border-transparent bg-primary py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
