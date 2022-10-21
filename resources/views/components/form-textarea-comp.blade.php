<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <textarea {{ $attributes->wire('model') }} name="{{ $for }}" id="{{ $for }}" rows="{{ $rows }}"
                  class="shadow-sm focus:ring-primary focus:border-primary @error($for) border-red-400 @else border-gray-300 @enderror block w-full sm:text-sm  rounded-md"></textarea>
        @error($for)
            <x-form-error-component message="{{ $message }}" />
        @enderror
    </div>
</div>
