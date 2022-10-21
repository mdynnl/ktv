@props(['hour', 'minute', 'lable'])

<div
     x-data="{
         model: @entangle($attributes->wire('model')),
         {{-- hour: {{ $hour }}, --}}
         {{-- minute: {{ $minute }}, --}}
         flatpickrInstance: null,
     }"
     x-init="() => {
         flatpickrInstance = flatpickr($refs.picker, {
             dateFormat: 'Y-m-d',
             {{-- defaultHour: hour, --}}
             {{-- defaultMinute: minute, --}}
         });
     
         flatpickrInstance.jumpToDate(model);
     }"
     class="mb-6">
    <label for="email" class="block text-sm font-medium text-white">{{ $lable }}</label>
    <div class="mt-1">
    </div>

    <div class="mt-1 relative rounded-md shadow-sm">
        <input
               wire:ignore
               x-ref="picker"
               x-model="model"
               class="custom-datepickr-styles">

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

</div>
