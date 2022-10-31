<div {{ $attributes->only('class') }}>
    <div class="flex items-center space-x-3">
        <label for="gender-select" class="block text-sm font-medium text-gray-700">Gender</label>
    </div>
    <div class="mt-1">
        <select {{ $attributes->wire('model') }} id="gender-select" name="gender-select"
                @class([
                    'block w-full focus:border-primary focus:ring-primary sm:text-sm rounded-md',
                    'border-red-400 z-10' => $errors->has($for),
                    'border-gray-300' => !$errors->has($for),
                ])>
            <option value=""></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    @error($for)
        <x-form-error-component message="{{ $message }}" />
    @enderror
</div>
