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

                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full bg-gray-100" :value="$inventory->quantity" disabled />
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

                        <form enctype="multipart/form-data" method="post" action="{{ '#' }}" class="mt-6 space-y-6" >
                            @csrf
                            @method('patch')

                            <div>
                                <label for="product_id" class="sr-only">{{ __('Product ID') }}</label>
                                <input name="product_id" type="hidden" :value="{{  $inventory->product_id }}" />

                                <label for="inventory_id" class="sr-only">{{ __('Inventory ID') }}</label>
                                <input name="inventory_id" type="hidden" value="{{  $inventory->id }}" />
                            </div>

                            <div class="mt-6 space-y-6">
                                @foreach($inventory->items as $item)
                                    <div class="mt-6 py-4 space-y-6 border-t">
                                        <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                            <div class="flex-1">
                                                <x-input-label for="sku" :value="__('SKU')"/>
                                                <x-text-input id="sku" name="items[{{$item->id}}][sku]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.sku', $item->sku)"
                                                              required autofocus autocomplete="sku"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.sku')"/>
                                            </div>
                                            <div class="flex-1">
                                                <x-input-label for="barcode" :value="__('Bar code')"/>
                                                <x-text-input id="barcode" name="items[{{$item->id}}][barcode]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.barcode', $item->barcode)" required
                                                              autofocus autocomplete="barcode"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.barcode]')"/>
                                            </div>
                                        </div>
                                        <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                            <div class="flex-1">
                                                <x-input-label for="purchase_price" :value="__('Price (Purchase)')"/>
                                                <x-text-input id="purchase_price" name="items[{{$item->id}}][purchase_price]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.purchase_price', $item->purchase_price)"
                                                              required autofocus autocomplete="purchase_price"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.purchase_price')"/>
                                            </div>
                                            <div class="flex-1">
                                                <x-input-label for="sell_price" :value="__('Price (Sell)')"/>
                                                <x-text-input id="sell_price" name="items[{{$item->id}}][sell_price]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.sell_price', $item->sell_price)" required
                                                              autofocus autocomplete="sell_price"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.sell_price]')"/>
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="quantity" :value="__('Quantity')" />
                                            <x-text-input id="quantity" name="items[{{$item->id}}][quantity]" type="text" class="mt-1 block w-full" :value="old('items.'.$item->id.'quantity', $item->quantity)" required autofocus autocomplete="quantity" />
                                            <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'quantity')" />
                                        </div>
                                        <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                            <div class="h-14 w-14 flex-shrink-0">
                                                <img class="h-14 w-14 rounded-full ring-2 ring-indigo-600 ring-offset-2" src="{{ $item->image }}" alt="{{ 'image of '.$item->product->name }}">
                                            </div>
                                            <div>
                                                <x-input-label for="image" :value="__('Image')" />
                                                <input id="image" name="items[{{$item->id}}][image]" type="file" class="mt-1 block w-full" value="{{old('items.'.$item->id.'image', $item->image)}}" />
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'image')" />
                                            </div>
                                        </div>

                                        {{--Optional Metadata--}}
                                        <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                            <div class="flex-1">
                                                <x-input-label for="size" :value="__('size')"/>
                                                <x-text-input id="size" name="items[{{$item->id}}][size]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.size', $item->size)"
                                                              required autofocus autocomplete="size"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.size')"/>
                                            </div>
                                            <div class="flex-1">
                                                <x-input-label for="color" :value="__('color')"/>
                                                <x-text-input id="color" name="items[{{$item->id}}][color]" type="text"
                                                              class="mt-1 block w-full"
                                                              :value="old('items.'.$item->id.'.color', $item->color)" required
                                                              autofocus autocomplete="color"/>
                                                <x-input-error class="mt-2" :messages="$errors->get('items.'.$item->id.'.color]')"/>
                                            </div>
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
