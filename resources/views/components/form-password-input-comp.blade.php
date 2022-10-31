<div x-cloak x-data="{ showPassword: false }" {{ $attributes->only('class') }}>
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="relative mt-1 rounded-md shadow-sm">
        <input {{ $attributes->wire('model') }} :type="showPassword ? 'text' : 'password'" name="{{ $for }}" id="{{ $for }}"
               class="shadow-sm focus:ring-primary focus:border-primary @error($for) border-red-400 @else border-gray-300 @enderror block w-full sm:text-sm  rounded-md">

        <button @click="showPassword = !showPassword" type="button" class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 aria-hidden="true">
                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                <path fill-rule="evenodd"
                      d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                      clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
