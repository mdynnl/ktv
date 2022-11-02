<div {{ $attributes->only('class') }}>
    <div class="flex flex-col space-y-1">

        @isset($preview)
            <div class="shrink-0">
                {{ $preview }}
            </div>
        @endisset

        <label class="block">
            <span class="mb-1 block text-sm font-medium text-gray-700">{{ $label }}</span>
            <input type="file"
                   {{ $attributes->wire('model') }}
                   class="block w-full text-sm text-slate-500
		  file:mr-4 file:py-2 file:px-4
		  file:rounded-md file:border-0
		  file:text-sm file:font-semibold
		  file:bg-primary file:text-white
		  hover:file:bg-blue-900
		" />
        </label>
    </div>
    @error($for)
        <x-form-error-component message="{{ $message }}" />
    @enderror
</div>
