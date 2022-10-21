<section class="mb-8 px-3">
    @isset($title)
        <header class="text-lg text-white">{{ $title }}</header>
    @endisset
    <div @class(['px-3', 'mt-3' => isset($title)])>
        {{ $slot }}
    </div>
</section>
