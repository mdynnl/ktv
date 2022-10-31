<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <input {{ $attributes->wire('model') }} type="{{ $type }}" name="{{ $for }}" id="{{ $for }}"
               class="shadow-sm focus:ring-primary focus:border-primary @error($for) border-red-400 @else border-gray-300 @enderror block w-full sm:text-sm  rounded-md">
        @error($for)
            <x-form-error-component message="{{ $message }}" />
        @enderror
    </div>
    <span class="text-xs text-gray-500">{{ $description }}</span>
</div>
