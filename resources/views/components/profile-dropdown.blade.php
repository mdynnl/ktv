<div x-data="{ open: false }" @click.outside="open=false" @close.stop="open = false" class="ml-3 relative">

    <div class="flex space-x-3 items-center">
        <div>
            <span class="font-medium text-gray-500 text-sm">
                {{ auth()->user()->name }}
            </span>
        </div>
        <button
                @click="open = !open"
                type="button"
                class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="sr-only">Open user menu</span>
            @if (auth()->user()->image)
                <img class="h-8 w-8 rounded-full"
                     src="{{ auth()->user()->getImage }}"
                     alt="Placeholder Image">
            @else
                <img class="h-8 w-8 rounded-full"
                     src="{{ asset('images/employee.png') }}"
                     alt="Placeholder Image">
            @endif
        </button>
    </div>
    <div
         x-cloak
         x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="z-[] origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        {{ $slot }}
        </form>
    </div>
</div>
