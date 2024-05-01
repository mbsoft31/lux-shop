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
                            action="{{ route('admin.products.update', $product->id) }}" class="mt-6 space-y-6">
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
                <div class="max-w-xl">
                    <livewire:product-meta-form :product="$product" />
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <livewire:product-variants-list :product="$product" />
            </div>
        </div>
    </div>

</x-admin-layout>
