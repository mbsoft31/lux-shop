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

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
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


    <div class="py-8">
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
                        </header>

                        <form method="post" action="{{ '#' }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="product_id" :value="__('Product ID')" />
                                <x-text-input id="product_id" name="product_id" type="text" class="mt-1 block w-full" :value="old('product_id', $inventory->product_id)" required autofocus autocomplete="product_id" />
                                <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
                            </div>

                            <div>
                                <x-input-label for="inventory_id" :value="__('Inventory ID')" />
                                <x-text-input id="inventory_id" name="inventory_id" type="text" class="mt-1 block w-full" :value="old('inventory_id', $inventory->id)" required autofocus autocomplete="inventory_id" />
                                <x-input-error class="mt-2" :messages="$errors->get('inventory_id')" />
                            </div>

                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full" :value="old('quantity', $inventory->quantity)" required autofocus autocomplete="quantity" />
                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                            </div>

                            <div class="mt-6 space-y-6">
                                @foreach($inventory->items as $item)
                                    <div class="mt-6 py-4 space-y-6 border-t">
                                        <div class="flex items-center gap-6">
                                            <div class="flex-1">
                                                <x-input-label for="purchase_price" :value="__('Price (Purchase)')"/>
                                                <x-text-input id="purchase_price" name="purchase_price" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('purchase_price', $item->purchase_price)"
                                                              required autofocus autocomplete="purchase_price"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('purchase_price')"/>
                                            </div>
                                            <div class="flex-1">
                                                <x-input-label for="sell_price" :value="__('Price (Sell)')"/>
                                                <x-text-input id="sell_price" name="sell_price" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('sell_price', $item->sell_price)" required
                                                              autofocus autocomplete="sell_price"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('sell_price')"/>
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="quantity" :value="__('Quantity')" />
                                            <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full" :value="old('quantity', $item->quantity)" required autofocus autocomplete="quantity" />
                                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                                            @if (session('status') === 'inventory-saved')
                                                <p
                                                    x-data="{ show: true }"
                                                    x-show="show"
                                                    x-transition
                                                    x-init="setTimeout(() => show = false, 2000)"
                                                    class="text-sm text-gray-600"
                                                >{{ __('Saved.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
