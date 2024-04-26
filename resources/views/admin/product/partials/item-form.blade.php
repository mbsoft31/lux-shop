<?php
use function Livewire\Volt\{state};

state([
    'item' => $item ?? null,
    'inventory' => $inventory
]);

$generateBarcode = function($inventoryId, $productId) {
    // Create a unique barcode format based on inventory and product IDs
    $barcode = 'BC-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . str_pad($productId, 5, '0', STR_PAD_LEFT);
    // Append a random three-digit number for uniqueness
    $barcode .= '-' . rand(100, 999);
    return $barcode;
};

$generateSKU = function($inventoryId) {
    // Create a SKU based on inventory ID
    $sku = 'SKU-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT);
    // Append a random three-digit number for uniqueness
    $sku .= '-' . rand(100, 999);
    return $sku;
};

if (!$this->item) {
    $this->item = new \App\Models\InventoryItem();
    $this->item->inventory_id = $inventory->id;
    $this->item->product_id = $inventory->product_id;

    // Generate a unique barcode
    $this->item->barcode = $generateBarcode($this->item->inventory_id, $this->item->product_id);

    // Generate a SKU
    $this->item->sku = $generateSKU($this->item->inventory_id);

    // Set default values
    $this->item->purchase_price = 0;
    $this->item->sell_price = 0;
    $this->item->quantity = 0;
    $this->item->size = 'M';
    $this->item->color = '';
}
?>
{{--@props(['item', 'inventory'])
@php
    $generateBarcode = function($inventoryId, $productId) {
        // Create a unique barcode format based on inventory and product IDs
        $barcode = 'BC-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT) . '-' . str_pad($productId, 5, '0', STR_PAD_LEFT);
        // Append a random three-digit number for uniqueness
        $barcode .= '-' . rand(100, 999);
        return $barcode;
    };

    $generateSKU = function($inventoryId) {
        // Create a SKU based on inventory ID
        $sku = 'SKU-' . str_pad($inventoryId, 5, '0', STR_PAD_LEFT);
        // Append a random three-digit number for uniqueness
        $sku .= '-' . rand(100, 999);
        return $sku;
    };
    if (!isset($item)) {
        $item = new \App\Models\InventoryItem();
        $item->inventory_id = $inventory->id;
        $item->product_id = $inventory->product_id;

        // Generate a unique barcode
        $item->barcode = $generateBarcode($item->inventory_id, $item->product_id);

        // Generate a SKU
        $item->sku = $generateSKU($item->inventory_id);

        // Set default values
        $item->purchase_price = 0;
        $item->sell_price = 0;
        $item->quantity = 0;
        $item->size = 'M';
        $item->color = '';
    }
@endphp--}}
<form
    x-data="{
        image: '{{ $item->image }}',
        updateImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                this.image = reader.result;
            };
            reader.readAsDataURL(file);
        },
        uploadImage(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            fetch(event.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        event.target.reset();
                        this.image = data.image;
                    }
                });
        },
    }"
    @submit.prevent="saveItem"
    enctype="multipart/form-data"
    method="post"
    action="{{ '#' }}"
    class="mt-6 space-y-6"
>
    @csrf
    @method('patch')

    <div>
        <label for="product_id" class="sr-only">{{ __('Product ID') }}</label>
        <input name="product_id" type="hidden" :value="{{  $inventory->product_id }}" />

        <label for="inventory_id" class="sr-only">{{ __('Inventory ID') }}</label>
        <input name="inventory_id" type="hidden" value="{{  $inventory->id }}" />
    </div>

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
            <x-secondary-button class="text-red-600 hover:bg-red-100 hover:border-red-600">{{ __('Delete') }}</x-secondary-button>
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
</form>
