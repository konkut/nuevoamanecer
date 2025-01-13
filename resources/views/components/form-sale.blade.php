<div class="mt-4">
    <x-label for="observation" value="{{ __('word.sale.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="focus-and-blur first-element pl-9 block mt-1 w-full" type="text"
                 name="observation" value="{{ old('observation', $sale->observation ?? '') }}"/>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_quantities = old('quantities', []);
        $old_product_uuids = old('product_uuids', []);
        $old_method_uuids = old('method_uuids', []);
        $max_old = max(count($old_quantities), count($old_product_uuids), count($old_method_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $quantities = $old_quantities[$index] ?? null;
                $product_uuid = $old_product_uuids[$index] ?? null;
                $method_uuid = $old_method_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                @if($page === 'CREATE')
                    <div class="mt-4 w-full md:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select class="product-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="product_uuids[{{ $index }}]"
                                    onchange="update_sale_charge()">
                                <option value="" disabled {{ (!isset($product_uuid))?'selected' : '' }}>{{ __('word.sale.select_product') }}</option>
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
                            <div class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg bg-gray-100">
                                {{ $products->firstWhere('product_uuid', $product_uuid)->name ?? __('word.sale.select_product') }}
                            </div>
                            <input type="hidden"
                                   class="product-input"
                                   name="product_uuids[{{ $index }}]"
                                   data-price="{{$products->firstWhere('product_uuid', $product_uuid)->price}}"
                                   value="{{ $product_uuid }}">
                        </div>
                    </div>
                @endif
                <div class="mt-4 w-full md:w-1/5">
                    <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_sale_charge()"
                                 class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text"
                                 name="quantities[{{ $index }}]"
                                 value="{{ $quantities ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-2/5">
                    <x-label value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="method_uuids[{{ $index }}]"
                                onchange="update_sale_charge()">
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
            $array_quantities = $sale->toArray()['quantities'] ?? [];
            $array_products = $sale->toArray()['product_uuids'] ?? [];
            $array_methods = $sale->toArray()['method_uuids'] ?? [];
            $max_update = max(count($array_quantities), count($array_products), count($array_methods));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $quantity = $array_quantities[$index] ?? null;
                    $product_uuid = $array_products[$index] ?? null;
                    $method_uuid = $array_methods[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full md:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.product_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <div class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg bg-gray-100">
                                {{ $products->firstWhere('product_uuid', $product_uuid)->name ?? __('word.sale.select_product') }}
                            </div>
                            <input type="hidden"
                                   class="product-input"
                                   name="product_uuids[{{ $index }}]"
                                   data-price="{{$products->firstWhere('product_uuid', $product_uuid)->price}}"
                                   value="{{ $product_uuid }}">
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/5">
                        <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                        <div class="relative">
                            <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input onkeyup="update_sale_charge()"
                                     class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                     type="text" name="quantities[{{ $index }}]"
                                     value="{{ $quantity ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full sm:w-2/5">
                        <x-label value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="method_uuids[{{ $index }}]"
                                    onchange="update_sale_charge()">
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
                        <select class="product-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="product_uuids[0]"
                                onchange="update_sale_charge()">
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
                    <x-label value="{{ __('word.sale.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_sale_charge()"
                                 class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text" name="quantities[0]"
                                 value="{{ $sale->quantities?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-2/5">
                    <x-label for="method_uuid" value="{{ __('word.sale.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="method_uuid"
                                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="method_uuids[0]"
                                onchange="update_sale_charge()">
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
                    onclick="update_sale_charge()">
                <i class="bi bi-dash mr-2"></i>{{ __('Quitar Fila') }}
            </button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-rows-container');
            const addRowButton = document.getElementById('add-row');
            const removeRowButton = document.getElementById('remove-row');
            // Agregar una nueva fila
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
            // Quitar la última fila
            removeRowButton.addEventListener('click', function () {
                const rows = container.querySelectorAll('.row-template');
                if (rows.length > 1) {
                    rows[rows.length - 1].remove();
                }
                update_sale_charge();
            });
        });
    </script>
@endif

