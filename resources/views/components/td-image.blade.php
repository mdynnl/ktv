<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 border-b border-gray-200 sm:pl-6">
    <div class="flex items-center">
        <div class="h-10 w-10 flex-shrink-0">
            <img {{ $attributes->merge(['class' => 'h-10 w-10 rounded-full']) }}
                 src="{{ $imagePath }}"
                 alt="">
        </div>
        <div class="ml-4">
            <div class="font-medium text-gray-900">{{ $name }}</div>
        </div>
    </div>
</td>
