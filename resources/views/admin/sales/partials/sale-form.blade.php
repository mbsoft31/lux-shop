<form wire:submit.prevent="saveSale" enctype="multipart/form-data" method="post" class="mt-6 space-y-6">
    <div>
        <x-input-label for="user_id" :value="__('User')" />
        @role(\Core\Auth\Enums\UserRole::ADMINISTRATOR->value)
            <select wire:model="form.user_id" id="user_id" name="user_id" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus>
                <option value="">{{ __('Select a User') }}</option>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        @endrole
        @role(\Core\Auth\Enums\UserRole::CASHIER->value)
            <input type="hidden" wire:model="form.user_id">
            <input disabled value="{{ Auth::user()->name }}" class="mt-1 py-2 px-2 block w-full border-gray-400 bg-gray-50 rounded-md shadow-sm">
        @endrole
        <x-input-error class="mt-2" :messages="$errors->get('form.user_id')" />
    </div>

    <div>
        <x-input-label for="customer_id" :value="__('Customer')" />
        {{--<select wire:model="form.customer_id" id="customer_id" name="customer_id" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">{{ __('Select a Customer') }}</option>
            @foreach($customers as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>--}}
        {{--<x-combo-box label="Select customer" key="id" value="name" :items="$customers" />--}}
        <div>
            <label for="combobox" class="block text-sm font-medium leading-6 text-gray-900">Assigned to</label>
            <div class="relative mt-2">
                <input value="{{$customers[$form['customer_id']]->name}}" id="combobox" type="text" class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" role="combobox" aria-controls="options" aria-expanded="false">
                <button wire:click="openCustomers" type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                @if($openCustomer)
                    <ul class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
                        @foreach($customers as $k => $v)
                            @php
                                $selected = $form['customer_id'] == $k;
                            @endphp
                            <li wire:click="select({{$k}})"
                                id="option-0"
                                role="option"
                                tabindex="-1"
                                class="relative cursor-default select-none py-2 pl-8 pr-4 {{ $selected ? "text-white bg-indigo-600" : "text-gray-900" }}"
                            >
                                <span class="block truncate {{ $selected ? "font-semibold" : '' }}">
                                    {{ $v->name }}
                                </span>
                                @if($selected)
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-1.5 {{ $selected ? "text-white" : "text-indigo-600" }}">
                                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        {{--<x-text-input wire:model="form.customer_id" id="customer_id" name="customer_id" type="text" class="mt-1 block w-full" required autofocus />--}}
        <x-input-error class="mt-2" :messages="$errors->get('form.customer_id')" />
    </div>

    <div>
        <x-input-label for="total_amount" :value="__('Total amount')" />
        <x-text-input wire:model="form.total_amount" id="total_amount" name="total_amount" type="text" class="mt-1 block w-full" required />
        <x-input-error class="mt-2" :messages="$errors->get('form.total_amount')" />
    </div>

    <div>
        <x-input-label for="payment_method" :value="__('Payment method')" />
        <select wire:model="form.payment_method" id="payment_method" name="payment_method" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">{{ __('Select a Payment method') }}</option>
            @foreach(\Core\Sales\Enums\PaymentMethod::cases() as $method)
                <option value="{{ $method->value }}">{{ $method->name }}</option>
            @endforeach
        </select>
        {{--<x-text-input wire:model="form.payment_method" id="payment_method" name="payment_method" type="text" class="mt-1 block w-full" required />--}}
        <x-input-error class="mt-2" :messages="$errors->get('form.payment_method')" />
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
