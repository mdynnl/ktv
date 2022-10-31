<x-page-layout>
    <x-slot:staticSidebarContent>
    </x-slot:staticSidebarContent>

    <div class="max-w-4xl">
        <article class="bg-white h-full pb-20">
            <!-- Profile header -->
            <div>
                <div>
                    <img class="h-32 w-full object-cover lg:h-48"
                         src="https://images.unsplash.com/photo-1444628838545-ac4016a5418a?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
                         alt="">
                </div>
                <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                    <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                        <div class="flex items-center space-x-6">
                            <img class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32"
                                 src="{{ $user->getImage }}"
                                 alt="">

                            <div>
                                <button type="button"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" aria-hidden="true">
                                        <path
                                              d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                        <path
                                              d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                    </svg>
                                    <span>Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 hidden min-w-0 flex-1 sm:block">
                        <h1 class="truncate text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    </div>
                </div>
            </div>


            <!-- Tabs -->
            {{-- <div class="mt-6 sm:mt-2 2xl:mt-5">
                <div class="border-b border-gray-200">
                    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <!-- Current: "border-pink-500 text-gray-900", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                            <a href="#"
                               class="border-pink-500 text-gray-900 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                               aria-current="page">Profile</a>

                            <a href="#"
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Calendar</a>

                            <a href="#"
                               class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Recognition</a>
                        </nav>
                    </div>
                </div>
            </div> --}}

            <!-- Description list -->
            <div class="mx-auto mt-6 max-w-5xl px-4 sm:px-6 lg:px-8 ">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->phone }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">Role</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->roleName() }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">NRC / Passport No:</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->nrc }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucwords($user->gender) }}</dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-primary">Birthday</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->dob }}</dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-primary">Address</dt>
                        <dd class="mt-1 max-w-prose space-y-5 text-sm text-gray-900">
                            <p>{{ $user->address }}</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </article>
    </div>
</x-page-layout>
