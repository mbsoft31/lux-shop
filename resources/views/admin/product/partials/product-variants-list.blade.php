<div class="">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">
                {{ __('Product Variants') }}
            </h1>
            <p class="mt-2 text-sm text-gray-700">
                {!! __('You can add, edit, and delete product variants here.') !!}
            </p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <livewire:inventory-item-form :label="__('Add Item')" :item="null" :inventory="$inventory" :product="$inventory->product" />
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{__('Quantity')}}</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($items as $item)
                        <tr>
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="h-11 w-11 flex-shrink-0">
                                        <img class="h-11 w-11 rounded-full"
                                             src="{{ $item?->image }}"
                                             alt=""
                                        >
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $item->sku }}
                                        </div>
                                        <div class="mt-1 text-gray-500 line-clamp-1">
                                            {{ $item->barcode }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $item->quantity >0 ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20' }}">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Active
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <livewire:inventory-item-form :label="__('Edit')" :item="$item" :inventory="$inventory" :product="$inventory->product" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" colspan="3">
                                {{ __('No items found.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
