@props(['label' => 'Select', 'for', 'options', 'optionValue' => 'name', 'optionDisplay' => 'name'])
<div {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="sr-only block text-sm font-medium text-gray-500">{{ $label }}</label>

    <div class="relative rounded-md shadow-sm">
        <select {{ $attributes->wire('model') }} id="{{ $for }}" name="{{ $for }}"
                class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md"
                placeholder="HEllo">
            <option value="">{{ $label }}</option>
            @foreach ($options as $option)
                <option value="{{ $option->$optionValue }}">{{ $option->$optionDisplay }}</option>
            @endforeach
        </select>
    </div>
</div>
