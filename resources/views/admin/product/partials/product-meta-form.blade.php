<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Product Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Enter the product's information.") }}
        </p>
    </header>

    <form wire:submit.prevent="saveMeta" enctype="multipart/form-data"  method="post" class="mt-6 space-y-6">

        <div class="flex items-center justify-between gap-4">
            <div class="flex-grow">
                <x-input-label for="meta.type" :value="__('Clothing type')" />
                <select
                    wire:model="meta.type"
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
                    wire:model="meta.size_type"
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

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'success')
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
