@props(['label', 'for', 'options', 'optionValue' => 'name', 'optionDisplay' => 'name', 'hasBlankOption' => true, 'isDisabled' => false])
<div {{ $attributes->only('class') }}>
    <div class="flex items-center space-x-3">
        <label for="{{ $for }}" class="block text-sm font-medium text-gray-700"> {{ $label }} </label>
    </div>
    <div
         @class([
             'mt-1',
             'flex items-center space-x-3' => isset($valueDisplay),
         ])>
        <div class="flex">
            <select {{ $attributes->wire('model') }} id="{{ $for }}" name="{{ $for }}"
                    {{ $isDisabled ? 'disabled' : '' }}
                    @class([
                        'block w-full focus:border-primary focus:ring-primary sm:text-sm',
                        'focus-within:z-10 rounded-none rounded-l-md' => isset($labelButton),
                        'rounded-md' => !isset($labelButton),
                        'border-red-400 z-10' => $errors->has($for),
                        'border-gray-300' => !$errors->has($for),
                    ])>
                @if ($hasBlankOption)
                    <option value=""></option>
                @endif
                @foreach ($options as $key => $option)
                    <option value="{{ $option->$optionValue }}" wire:key="{{ $option->$optionValue . '-' . $option->$optionDisplay }}">
                        {{ $option->$optionDisplay }}
                    </option>
                @endforeach
            </select>
            @isset($labelButton)
                <div>{{ $labelButton }}</div>
            @endisset
        </div>
        @isset($valueDisplay)
            <div class="px-3 py-2 rounded-md sm:text-sm">
                <span>{{ $valueDisplay }}</span>
            </div>
        @endisset
    </div>
    @error($for)
        <x-form-error-component message="{{ $message }}" />
    @enderror
</div>
