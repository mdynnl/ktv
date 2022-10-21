<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-1">
        <input {{ $attributes->wire('model') }} type="time" name="{{ $for }}"
               id="{{ $for }}"
               {{ $attributes->only('max') }}
               {{ $attributes->only('min') }}
               {{ $isDisabled ? 'disabled' : '' }}
               class="shadow-sm focus:ring-primary focus:border-primary  border-gray-300 block w-full sm:text-sm  rounded-md">
        @error('{{ $for }}')
            <x-form-error-component message="{{ $message }}" />
        @enderror
    </div>
</div>
