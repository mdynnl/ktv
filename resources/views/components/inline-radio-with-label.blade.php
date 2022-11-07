<div class="flex items-center">
    <input {{ $attributes->wire('model') }} id="{{ $for }}" name="{{ $for }}" type="radio" value="{{ $value }}"
           class="h-4 w-4 border-gray-300 text-primary focus:ring-primary">
    <label for="{{ $for }}" class="ml-3 block text-sm font-medium text-gray-700">{{ $label }}</label>
</div>
