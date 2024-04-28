<x-admin-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Product Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Enter the product's information.") }}
                            </p>
                        </header>

                        <form x-data="{
                                image: '{{ $product->image }}',
                                updateImage(event) {
                                    const file = event.target.files[0];
                                    const reader = new FileReader();
                                    reader.onload = () => {
                                        this.image = reader.result;
                                    };
                                    reader.readAsDataURL(file);
                                },
                            }"
                            enctype="multipart/form-data"
                            method="post"
                            action="{{ route('admin.product.update', $product->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $product->description)" required autofocus autocomplete="description" />
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full bg-gray-100" :value="$inventory->quantity" disabled />
                            </div>

                            <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                <div class="h-64 w-64 flex-shrink-0">
                                    <img class="h-64 w-64 rounded-full ring-2 ring-indigo-600 ring-offset-2 object-cover" src="{{$product->image}}" alt="{{ 'image of '.$product->name }}">
                                </div>
                                <div>
                                    <x-input-label for="image" :value="__('Image')" />
                                    <input id="image" name="image" type="file" class="mt-1 block w-full" @change="updateImage" />
                                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'product-saved')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
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
                                    @forelse($inventory->items as $item)
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
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
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
            </div>
        </div>
    </div>

    {{--<div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Inventory Item Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Enter the inventory item's information.") }}
                            </p>

                            <div x-data="{ open: false }" class="flex items-center gap-4 mt-6">
                                <x-primary-button @click="open = true">
                                    {{ __('Add New Item') }}
                                </x-primary-button>
                                <div class="relative z-50" role="dialog" aria-modal="true">
                                    <div
                                        x-show="open"
                                        x-transition:enter="ease-in-out duration-500"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in-out duration-500"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                        aria-hidden="true"
                                    ></div>

                                    <div x-show="open" class="fixed inset-0 overflow-hidden">
                                        <div class="absolute inset-0 overflow-hidden">
                                            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                                                <div
                                                    x-show="open"
                                                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                                    x-transition:enter-start="translate-x-full"
                                                    x-transition:enter-end="translate-x-0"
                                                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                                    x-transition:leave-start="translate-x-0"
                                                    x-transition:leave-end="translate-x-full"
                                                    class="pointer-events-auto relative w-screen max-w-md"
                                                >
                                                    <div
                                                        x-show="open"
                                                        x-transition:enter="ease-in-out duration-500"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in-out duration-500"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0"
                                                        class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4"
                                                    >
                                                        <button type="button" class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                            <span class="absolute -inset-2.5"></span>
                                                            <span class="sr-only">Close panel</span>
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div
                                                        x-show="open"
                                                        @click.away="open = false"
                                                        class="h-full overflow-y-auto bg-white p-8"
                                                    >
                                                        @livewire('admin.product.partials.item-form', ['item' => null, 'inventory' => $inventory])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>

                        <div class="mt-6 space-y-6">
                            @foreach($inventory->items as $item)
                                @livewire('admin.product.partials.item-form', ['item' => $item, 'inventory' => $inventory])
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>--}}

</x-admin-layout>
