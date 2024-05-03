<x-admin-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:sale-create-form />
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="px-4 sm:px-6 lg:px-8">
                    <form class="relative flex flex-1" action="#" method="GET">
                        <x-input-label for="search-field" class="sr-only">Search</x-input-label>
                        <svg class="pointer-events-none absolute inset-y-0 ltr:left-0 rtl:right-0 h-full w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                        <x-text-input id="search-field" class="block h-full w-full ltr:pl-8 rtl:pr-8" placeholder="Search..." type="search" name="search" />
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
