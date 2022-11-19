<div x-data="{
    show: @entangle($attributes->wire('model')),
}"
     @keydown.window.escape="show = false" class="relative z-[1000]" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">
    <div
         x-show="show"
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div
         x-show="show"
         x-cloak
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed z-50 inset-0 overflow-y-auto">
        <div class=" flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <div
                 @class([
                     'relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 w-full',
                     'max-w-md' => $size == 'sm',
                     'max-w-xl' => $size == 'md',
                     'max-w-2xl' => $size == 'md2',
                     'max-w-4xl' => $size == 'lg',
                     'max-w-5xl' => $size == 'xl',
                     'max-w-7xl' => $size == 'xxl',
                 ])>
                <div class="bg-white  shadow overflow-hidden sm:rounded-lg" x-trap.noscroll="show">

                    <div class="bg-primary flex items-center justify-between px-6 py-4 text-white">
                        @isset($modalHeader)
                            {{ $modalHeader }}
                        @endisset

                    </div>

                    <div @class(['my-8 px-6' => isset($modalAction)])>
                        {{ $slot }}
                    </div>

                    <div class="py-3 bg-gray-200 px-6 flex justify-between">
                        <div>
                            @isset($modalLeftAction)
                                {{ $modalLeftAction }}
                            @endisset
                        </div>
                        <div class="flex justify-end space-x-3 bg-gray-200">
                            @isset($modalAction)
                                <button @click="show = false" type="button"
                                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">{{ isset($cancelButtonLabel) ? $cancelButtonLabel : 'Cancel' }}</button>
                                {{ $modalAction }}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
