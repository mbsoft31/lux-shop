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
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">
                                {{ __('Sales') }}
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">
                                {!! __('You can add, edit, and delete products here.') !!}
                            </p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            {{--<x-primary-button link="true" href="{{ route('admin.products.create') }}">
                                {{ __('Add Sale') }}
                            </x-primary-button>--}}
                            {{--<livewire:product-create-form :show="false" :label="__('Add Sale')" />--}}
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($sales as $sale)
                                        <tr>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="flex items-center">
                                                    {{--<div class="h-11 w-11 flex-shrink-0">
                                                        <img class="h-11 w-11 rounded-full" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                                    </div>--}}
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $sale->customer_id }}
                                                        </div>
                                                        <div class="mt-1 text-gray-500 line-clamp-1">
                                                            {{ $sale->total_amount }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                    {{ $sale->payment_method }}
                                                </span>
                                            </td>
                                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="{{ '#'/*route('admin.sales.edit', $sale->id)*/ }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                    <div class="inline sr-only">, {{ $sale->id }}</div>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" colspan="3">
                                                {{ __('No sales found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
