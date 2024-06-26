<div x-data="{open: @entangle('show')}" class="relative isolate z-50" role="dialog" aria-modal="true">
    <div>
        <x-primary-button @click="open = true">
            {{ $label }}
        </x-primary-button>
    </div>
    <div x-show="open" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" style="display: none"></div>

    <div x-show="open" class="fixed inset-0 overflow-hidden" style="display: none">
        <div x-show="open" class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="open" style="display: none" class="pointer-events-auto relative isolate w-screen max-w-md" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    <div x-show="open" class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <button @click="open = false" type="button" class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="absolute -inset-2.5"></span>
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div x-show="open" style="display: none" class="h-full overflow-y-auto bg-white p-8">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Product Information') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __("Enter the product's information.") }}
                                </p>
                            </header>

                            <form wire:submit.prevent="saveProduct" enctype="multipart/form-data"  method="post" class="mt-6 space-y-6">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input wire:model="form.name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('form.name')" />
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <x-input-label for="purchase_price" :value="__('Price (Purchase)')" />
                                        <x-text-input wire:model="form.purchase_price" id="purchase_price" name="purchase_price" type="text" class="mt-1 block w-full" required autofocus autocomplete="purchase_price" />
                                        <x-input-error class="mt-2" :messages="$errors->get('form.purchase_price')" />
                                    </div>

                                    <div class="flex-grow">
                                        <x-input-label for="sell_price" :value="__('Price (Sell)')" />
                                        <x-text-input wire:model="form.sell_price" id="sell_price" name="sell_price" type="text" class="mt-1 block w-full" required autofocus autocomplete="sell_price" />
                                        <x-input-error class="mt-2" :messages="$errors->get('form.sell_price')" />
                                    </div>

                                </div>

                                <div>
                                    <x-input-label for="quantity" :value="__('Quantity')" />
                                    <x-text-input wire:model="form.quantity" id="quantity" name="quantity" type="text" class="mt-1 block w-full" required autofocus autocomplete="quantity" />
                                    <x-input-error class="mt-2" :messages="$errors->get('form.quantity')" />
                                </div>

                                <div>
                                    <div class='block font-semibold text-lg text-gray-700 border-b'>
                                        {{ __('Meta Information') }}
                                    </div>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <x-input-label for="meta.type" :value="__('Clothing type')" />
                                        <select
                                            wire:model="form.meta.type"
                                            wire:change="updateMetaSizeType"
                                            id="meta.type"
                                            name="meta.type"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        >
                                            @foreach($metaConfig['type']['options'] as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex-grow">
                                        <x-input-label for="meta.size_type" :value="__('Size type')" />
                                        <select
                                            wire:model="form.meta.size_type"
                                            id="meta.size_type"
                                            name="meta.size_type"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        >
                                            @foreach($metaConfig['size_type']['options'] as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                {{--<div>
                                    <x-input-label for="description" :value="__('Description')" />
                                    <x-text-input wire:model="form.description" id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description')" autocomplete="description" />
                                    <x-input-error class="mt-2" :messages="$errors->get('form.description')" />
                                </div>--}}

                                {{--<div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-center">
                                    <div class="h-14 w-14 flex-shrink-0">
                                        @if ($form['image'] instanceof TemporaryUploadedFile)
                                            <img src="{{ $form->image->temporaryUrl() }}" alt="{{ 'image of '}}" class="h-14 w-14 rounded-full ring-2 ring-indigo-600 ring-offset-2">
                                        @else
                                            <img src="https://placehold.co/400" alt="{{ 'image of '}}" class="h-14 w-14 rounded-full ring-2 ring-indigo-600 ring-offset-2">
                                        @endif
                                    </div>

                                    <div>
                                        <x-input-label for="image" :value="__('Image')"/>
                                        <input wire:model="form.image" id="image" name="image" type="file" class="mt-1 block w-full" />
                                        <x-input-error class="mt-2" :messages="$errors->get('form.image')"/>
                                    </div>
                                </div>--}}

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
    </div>
</div>



