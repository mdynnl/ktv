<div class="relative flex items-center space-x-5">
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
                   'font-medium disabled:text-gray-400 enabled:text-gray-700 flex items-center space-x-5 cursor-pointer',
                   'text-gray-400' => $isDisabled,
                   'text-gray-700' => !$isDisabled,
               ])>
            <img class="h-10 w-10 rounded-full" src="{{ $image }}" alt="{{ $for }}">
            <span>
                {{ $label }}
            </span>
        </label>
    </div>
</div>
