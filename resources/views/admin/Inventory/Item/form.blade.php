<div x-data="{open: @entangle('show')}" role="dialog" aria-modal="true">
    <div>
        <x-primary-button @click="open = true">
            {{ $label }}
        </x-primary-button>
    </div>
    <div x-show="open" class="z-50 fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none"></div>

    <div x-show="open" class="z-50 fixed inset-0 overflow-hidden" style="display: none">
        <div x-show="open" class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="open" style="display: none" class="pointer-events-auto relative w-screen max-w-md" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
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
                        <form wire:submit.prevent="saveItem" enctype="multipart/form-data" method="post" class="mt-6 space-y-6">
                            <div class="mt-6 py-4 space-y-6 border-t">
                                <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-start">
                                    <div class="flex-1">
                                        <x-input-label for="barcode" :value="__('Bar code')"/>
                                        <x-text-input wire:model="form.barcode" id="barcode" name="barcode" type="text" class="mt-1 block w-full" required autofocus autocomplete="barcode"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.barcode')"/>
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="quantity" :value="__('Quantity')"/>
                                    <x-text-input wire:model="form.quantity" id="quantity" name="quantity" type="text" class="mt-1 block w-full" required autofocus autocomplete="quantity"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('form.quantity')"/>
                                </div>

                                {{--Optional Metadata--}}
                                <div class="flex gap-6 flex-wrap flex-col sm:flex-row sm:items-start">
                                    <div class="flex-1">
                                        <x-input-label for="size" :value="__('size')"/>
                                        <select wire:model="form.meta.size" id="size" name="size" class="mt-1 block w-full" required autofocus autocomplete="size">
                                            <option value="">Select Size</option>
                                            @foreach($sizes as $key => $value)
                                                <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        {{--<x-text-input wire:model="form.meta.size" id="size" name="size" type="text" class="mt-1 block w-full" required autofocus autocomplete="size"/>--}}
                                        <x-input-error class="mt-2" :messages="$errors->get('form.size')"/>
                                    </div>
                                    <div class="flex-1">
                                        <x-input-label for="color" :value="__('color')"/>
                                        <x-text-input wire:model="form.meta.color" id="color" name="color" type="color" class="mt-1 block w-full h-10 p-0" autofocus autocomplete="color"/>
                                        <x-input-error class="mt-2" :messages="$errors->get('form.color')"/>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    <x-secondary-button
                                        class="text-red-600 hover:bg-red-100 hover:border-red-600">{{ __('Delete') }}</x-secondary-button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
