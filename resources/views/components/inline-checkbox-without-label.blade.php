<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input {{ $attributes->wire('model') }} value="{{ $value }}" aria-describedby="comments-description"
               name="comments" type="checkbox"
               class="focus:ring-transparent ring-0 h-4 w-4 text-blue-900 rounded cursor-pointer">
    </div>
</div>
