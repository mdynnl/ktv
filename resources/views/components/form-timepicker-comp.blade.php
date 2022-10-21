@props(['label', 'for'])

<div
     wire:ignore
     {{ $attributes->only('class') }}
     x-data="{
         model: @entangle($attributes->wire('model')),
         picker: null,
     }"
     x-init="() => {
         picker = flatpickr($refs.arrivalTimePicker, {
             noCalendar: true,
             altInput: true,
             altFormat: 'h:i K',
             dateFormat: 'H:i',
             enableTime: true,
             onChange: (selectedD, dateStr, instance) => {
                 model = dateStr
             }
         });
         picker.setDate(model);
         $watch('model', value => {
             picker.setDate(value)
         });
     }">
    <label for="date" class="block text-sm font-medium text-gray-700">{{ $label }}</label>

    <div class="mt-1 relative rounded-md shadow-sm">
        <input style="font-size: 1rem; cursor: pointer; text-align: left;" x-ref="arrivalTimePicker"
               class="shadow-sm focus:ring-primary focus:border-primary border-gray-300 block w-full sm:text-sm py-2 pl-3 rounded-md">
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>
    @error($for)
        <x-form-error-component message="{{ $message }}" />
    @enderror
</div>
