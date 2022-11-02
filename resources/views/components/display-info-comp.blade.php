<div {{ $attributes->merge(['class']) }}>
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <div
             class="bg-gray-100 block border border-gray-300 h-[2.4rem] py-2 px-3 overflow-hidden rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
            <span>{{ $displayValue }}</span>
        </div>
    </div>
</div>
