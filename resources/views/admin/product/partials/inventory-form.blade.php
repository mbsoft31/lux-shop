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
            <x-text-input id="product_id" name="product_id" type="text" class="mt-1 block w-full" :value="old('product_id')" required autofocus autocomplete="product_id" />
            <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
        </div>

        <div>
            <x-input-label for="inventory_id" :value="__('Inventory ID')" />
            <x-text-input id="inventory_id" name="inventory_id" type="text" class="mt-1 block w-full" :value="old('inventory_id')" required autofocus autocomplete="inventory_id" />
            <x-input-error class="mt-2" :messages="$errors->get('inventory_id')" />
        </div>

        <div>
            <x-input-label for="quantity" :value="__('Quantity')" />
            <x-text-input id="quantity" name="quantity" type="text" class="mt-1 block w-full" :value="old('quantity')" required autofocus autocomplete="quantity" />
            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" :value="old('price')" required autofocus autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>

        <div>
            <x-input-label for="discount" :value="__('Discount')" />
            <x-text-input id="discount" name="discount" type="text" class="mt-1 block w-full" :value="old('discount')" required autofocus autocomplete="discount" />
            <x-input-error class="mt-2" :messages="$errors->get('discount')" />
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
    </form>
</section>
