<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <input {{ $attributes->wire('model') }} type="number" name="{{ $for }}"
               {{ $attributes->only('min') }}
               {{ $attributes->only('max') }}
               id="{{ $for }}"
               placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
               class="shadow-sm focus:ring-primary focus:border-primary @error($for) border-red-400 @else border-gray-300 @enderror block w-full sm:text-sm  rounded-md">
    </div>
</div>
