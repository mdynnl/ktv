<div class="relative flex items-start">
    <div class="flex h-5 items-center">
        <input {{ $attributes->wire('model') }} id="{{ $for }}"
               disabled
               aria-describedby="comments-description" name="{{ $for }}"
               value="{{ $value }}"
               type="checkbox"
               {{-- class="h-4 w-4 rounded-full text-primary"> --}}
               style="color: #45B69C"
               {{-- style="color: #21D19F" --}}
               class="h-4 w-4 rounded-full">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $for }}" class="font-medium text-gray-700">
            {{ $label }}</label>
    </div>
</div>
