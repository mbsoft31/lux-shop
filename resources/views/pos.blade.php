<x-empty-layout>
    <section class="min-h-full w-full flex items-start bg-gray-50">
        <div class="px-6 py-4 flex-grow max-w-5xl bg-white">
            <header>
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($types as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        @foreach($types as $key => $value)
                            <!-- Current: "bg-gray-100 text-gray-700", Default: "text-gray-500 hover:text-gray-700"  aria-current="page"-->
                            <a href="#{{$key}}" class="text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium">
                                {{ $value }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </header>
            <div class="bg-gray-50"></div>
        </div>
        <div class="h96 flex-shrink-0 w-full max-w-md bg-gray-50">
            <header class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Walk-in Cart') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("here's the list of product to sell") }}
                </p>
            </header>
            <div>
                <div class="inline-block min-w-full">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            {{ __('Items') }}
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            {{ __('Price') }}
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-end text-sm font-semibold text-gray-900">
                            {{ __('Quantity') }}
                        </th>
                        </thead>
                        <tbody>
                        @foreach([1,2,3] as $index)
                            <tr>
                                <td class="whitespace-nowrap py-2 px-2 text-sm">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-xl" src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                        </div>
                                        <div class="ml-2 space-y-2">
                                            <div class="text-xs font-medium text-gray-900">Tn</div>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <div
                                                    class="w-4 h-4 rounded-full"
                                                    style="background-color: {{ '#000000' }}"
                                                ></div>
                                                <div>
                                                    {{ __('Size') }} : {{ 39 }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 px-2 text-sm">
                                    <div class="flex text-xs text-gray-700 font-semibold">
                                        {{ __('Amount') }} : {{ 100 }} {{ 'DZD' }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-700 font-semibold">
                                        <x-input-label for="discount" class="text-xs" :value="__('Discount')" />
                                        <x-text-input class="text-xs w-16 h-full py-0 text-start" value="{{ 0.0 }}" /> {{ 'DZD' }}
                                    </div>
                                </td>
                                <td class="flex whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                                    <div class="flex-shrink flex items-center justify-end bg-indigo-500 rounded-md overflow-hidden">
                                        <button class="px-2 py-px text-white font-semibold hover:bg-indigo-700">-</button>
                                        <x-text-input class="text-sm w-8 py-0 text-center" value="{{ 1 }}" />
                                        <button class="px-2 py-px text-white font-semibold hover:bg-indigo-700">+</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-empty-layout>
