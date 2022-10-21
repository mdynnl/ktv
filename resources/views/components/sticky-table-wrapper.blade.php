{{-- <div style="height: calc(100vh - 175px)" class="h-screen border overflow-y-scroll relative rounded-xl shadow-md"> --}}
{{-- <div style="max-height: calc(100vh - 175px)" class="min-h-[50vh] border overflow-y-auto relative rounded-xl shadow-md"> --}}
<div style="max-height: calc(100vh - 175px)" class="border overflow-y-auto relative rounded-xl shadow-md">
    <table class="min-w-full border-separate mb-10" style="border-spacing: 0">
        {{ $slot }}
    </table>
</div>
