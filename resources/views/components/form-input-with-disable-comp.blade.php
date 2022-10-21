<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <input {{ $attributes->wire('model') }} type="{{ $type }}" name="{{ $for }}"
               id="{{ $for }}"
               placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
               {{ $isDisabled ? 'disabled' : '' }}
               class="shadow-sm disabled:bg-gray-100 disabled:text-gray-500 enabled:bg-white focus:ring-primary focus:border-primary @error($for) border-red-400 @else border-gray-300 @enderror block w-full sm:text-sm  rounded-md">
        @error($for)
            <x-form-error-component message="{{ $message }}" />
        @enderror
    </div>
</div>
