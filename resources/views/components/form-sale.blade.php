<div class="mt-4">
    <x-label for="observation" value="{{ __('word.sale.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="focus-and-blur first-element pl-9 block mt-1 w-full" type="text"
                 inputmode="text" autocomplete="one-time-code" name="observation"
                 value="{{ old('observation', $sale->observation ?? '') }}"/>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_amounts = old('amounts', []);
        $old_quantities = old('quantities', []);
        $old_product_uuids = old('product_uuids', []);
        $old_method_uuids = old('method_uuids', []);
        $max_old = max(count($old_amounts), count($old_quantities), count($old_product_uuids), count($old_method_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $amount = $old_amounts[$index] ?? null;
                $quantity = $old_quantities[$index] ?? null;
                $product_uuid = $old_product_uuids[$index] ?? null;
                $method_uuid = $old_method_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                @if($page === 'CREATE')
                    <div class="mt-4 w-full md:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="product-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="product_uuids[{{ $index }}]"
                                    onchange="update_amount(this)">
                                <option value=""
                                        disabled {{ (!isset($product_uuid))?'selected' : '' }}>{{ __('word.sale.select_product') }}</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->product_uuid }}"
                                            data-price="{{ $item->price }}"
                                            data-stock="{{ $item->stock }}"
                                    @if(isset($product_uuid))
                                        {{ $item->product_uuid === $product_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <div class="mt-4 w-full md:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <div class="border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 pl-9 pr-3 py-2 shadow-sm rounded-md bg-gray-100">
                                {{ $products->firstWhere('product_uuid', $product_uuid)->name ?? __('word.sale.select_product') }}
                            </div>
                            <input type="hidden"
                                   class="product-input"
                                   name="product_uuids[{{ $index }}]"
                                   value="{{ $product_uuid }}">
                        </div>
                    </div>
                @endif
                <div class="mt-4 w-full md:w-1/5">
                    <x-label value="{{ __('word.sale.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount(this)"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amounts[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $amount == 0 ? '' : (float) number_format($amount, 2, '.', '') }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/5">
                    <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required onkeyup="update_amount(this)"
                                 class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                 inputmode="numeric" autocomplete="one-time-code"
                                 type="text"
                                 name="quantities[{{ $index }}]"
                                 value="{{ $quantity ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-2/5">
                    <x-label value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="method_uuids[{{ $index }}]"
                                onchange="update_amount(this)">
                            <option value="" disabled data-name="None" {{ (!isset($nmethod_uuid))?'selected' : '' }}>
                                {{ __('word.sale.select_method') }}
                            </option>
                            @foreach ($methods as $item)
                                <option value="{{ $item->method_uuid }}"
                                        data-name="{{ $item->name }}"
                                @if(isset($method_uuid))
                                    {{ $item->method_uuid === $method_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endfor
    @else
        @php
            $array_amounts = $sale->toArray()['amounts'] ?? [];
            $array_quantities = $sale->toArray()['quantities'] ?? [];
            $array_products = $sale->toArray()['product_uuids'] ?? [];
            $array_methods = $sale->toArray()['method_uuids'] ?? [];
            $max_update = max(count($array_quantities), count($array_products), count($array_methods), count($array_amounts));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $amount = $array_amounts[$index] ?? null;
                    $quantity = $array_quantities[$index] ?? null;
                    $product_uuid = $array_products[$index] ?? null;
                    $method_uuid = $array_methods[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full md:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <div class="border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 pl-9 pr-3 py-2 shadow-sm rounded-md bg-gray-100">
                                {{ $products->firstWhere('product_uuid', $product_uuid)->name ?? __('word.sale.select_product') }}
                            </div>
                            <input type="hidden"
                                   class="product-input"
                                   name="product_uuids[{{ $index }}]"
                                   value="{{ $product_uuid }}">
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/5">
                        <x-label value="{{ __('word.sale.attribute.amount') }} *"/>
                        <div class="relative">
                            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input onkeyup="update_amount(this)"
                                     class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="amounts[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $amount == 0 ? '' : (float) number_format($amount, 2, '.', '') }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/5">
                        <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                        <div class="relative">
                            <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input required onkeyup="update_amount(this)"
                                     class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="quantities[{{ $index }}]"
                                     inputmode="numeric" autocomplete="one-time-code"
                                     value="{{ $quantity ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full sm:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="method_uuids[{{ $index }}]"
                                    onchange="update_amount(this)">
                                <option value="" disabled data-name="None" {{ (!isset($method_uuid))?'selected' : '' }}>
                                    {{ __('word.sale.select_method') }}
                                </option>
                                @foreach($methods as $item)
                                    <option value="{{ $item->method_uuid }}"
                                            data-name="{{ $item->name }}"
                                    @if(isset($method_uuid))
                                        {{ $item->method_uuid === $method_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-2/5">
                    <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="product-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="product_uuids[0]"
                                onchange="update_amount(this)">
                            <option value="" disabled selected>{{ __('word.sale.select_product') }}</option>
                            @foreach ($products as $item)
                                <option value="{{ $item->product_uuid }}"
                                        data-price="{{ $item->price }}"
                                        data-stock="{{ $item->stock }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/5">
                    <x-label value="{{ __('word.sale.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount(this)"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amounts[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $sale->amounts == 0 ? '' : (float) number_format($sale->amounts, 2, '.', '') }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/5">
                    <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required onkeyup="update_amount(this)"
                                 class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="quantities[0]"
                                 inputmode="numeric" autocomplete="one-time-code"
                                 value="{{ $sale->quantities?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-2/5">
                    <x-label for="method_uuid" value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required id="method_uuid"
                                class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="method_uuids[0]"
                                onchange="update_amount(this)">
                            <option value="" disabled data-name="None"
                                    selected>{{ __('word.sale.select_method') }}</option>
                            @foreach ($methods as $item)
                                <option value="{{ $item->method_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@if($page === "CREATE")
    <div class="flex flex-col md:flex-row md:justify-evenly mt-6 space-y-4 md:space-y-0">
        <div class="flex justify-center">
            <button type="button" id="add-row"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
            </button>
        </div>
        <div class="flex justify-center">
            <button type="button" id="remove-row"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg"
                    onclick="update_amount()">
                <i class="bi bi-dash mr-2"></i>{{ __('Quitar Fila') }}
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-rows-container');
            const addRowButton = document.getElementById('add-row');
            const removeRowButton = document.getElementById('remove-row');
            addRowButton.addEventListener('click', function () {
                const template = document.querySelector('.row-template');
                const newIndex = container.children.length;
                const newRow = template.cloneNode(true);
                newRow.querySelectorAll('select').forEach(select => {
                    select.value = '';
                    const name = select.getAttribute('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                        select.setAttribute('name', updatedName);
                    }
                });
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = ''
                    const name = input.getAttribute('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                        input.setAttribute('name', updatedName);
                    }
                });
                container.appendChild(newRow);
            });
            removeRowButton.addEventListener('click', function () {
                const rows = container.querySelectorAll('.row-template');
                if (rows.length > 1) {
                    rows[rows.length - 1].remove();
                }
                update_amount();
            });
        });
    </script>
@endif

