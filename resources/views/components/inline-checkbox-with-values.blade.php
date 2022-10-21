<div {{ $attributes->wire('key') }} class="relative flex items-start">
    <div class="flex items-center h-5">
        <input {{ $attributes->wire('model') }} id="{{ $for }}" value="{{ $value }}" aria-describedby="comments-description"
               name="comments" type="checkbox"
               class="focus:ring-transparent ring-0 h-4 w-4 text-blue-900 rounded cursor-pointer">
    </div>
    <div class="ml-3 text-sm flex justify-between w-full">
        <label for="{{ $for }}" class="font-medium text-white cursor-pointer">{{ $label }}</label>
        @isset($displayValue)
            <span id="comments-description" class="text-white">{{ $displayValue }}</span>
        @endisset
    </div>
</div>
