<div {{ $attributes->only('class') }}>
    <label for="{{ $label }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div
         @class([
             'mt-1',
             'flex items-center space-x-3' => isset($valueDisplay),
         ])>
        <div>
            <input {{ $attributes->wire('model') }} type="text" name="{{ $label }}" id="{{ $label }}" disabled
                   class="bg-gray-100 block border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm sm:text-sm text-gray-500 w-full">
        </div>
        @isset($valueDisplay)
            <div class="px-3 py-2 rounded-md sm:text-sm">
                <span>{{ $valueDisplay }}</span>
            </div>
        @endisset
    </div>
</div>
