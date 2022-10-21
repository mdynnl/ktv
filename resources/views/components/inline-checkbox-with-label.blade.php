<div class="relative flex items-start">
    <div class="flex h-5 items-center">
        <input {{ $attributes->wire('model') }} id="{{ $for }}"
               {{ $isDisabled ? 'disabled' : '' }}
               aria-describedby="comments-description" name="{{ $for }}"
               value="{{ $value }}"
               type="checkbox"
               class="h-4 w-4 rounded disabled:border-gray-100 enabled:border-gray-300 text-primary focus:ring-primary">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $for }}"
               @class([
                   'font-medium disabled:text-gray-400 enabled:text-gray-700',
                   'text-gray-400' => $isDisabled,
                   'text-gray-700' => !$isDisabled,
               ])>{{ $label }}</label>
    </div>
</div>
