<div class="mt-4">
    <x-label for="observation" value="{{ __('word.income.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 type="text" inputmode="text" autocomplete="one-time-code"
                 name="observation" value="{{ old('observation', $income->observation?? '') }}"/>
    </div>
</div>

<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_codes = old('codes', []);
        $old_service_uuids = old('service_uuids', []);
        $old_amounts = old('amounts', []);
        $old_commissions = old('commissions', []);
        $old_quantities = old('quantities', []);
        $old_method_uuids = old('method_uuids', []);
        $old_bankregister_uuids = old('bankregister_uuids', []);
        $max_old = max(count($old_codes),count($old_service_uuids), count($old_amounts), count($old_commissions), count($old_quantities), count($old_method_uuids), count($old_bankregister_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $code = $old_codes[$index] ?? null;
                $service_uuid = $old_service_uuids[$index] ?? null;
                $amount = $old_amounts[$index] ?? null;
                $commission = $old_commissions[$index] ?? null;
                $quantity = $old_quantities[$index] ?? null;
                $method_uuid = $old_method_uuids[$index] ?? null;
                $bankregister_uuid = $old_bankregister_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.code') }} "/>
                    <div class="relative">
                        <i class="bi bi-123 absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="first-element focus-and-blur pl-9 pr-3 block w-full" type="text"
                                 inputmode="text" autocomplete="one-time-code"
                                 name="codes[{{ $index }}]"
                                 value="{{ $code ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.service_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="service_uuids[{{ $index }}]"
                            onchange="update_service()">
                            <option value=""
                                    disabled {{ (!isset($service_uuid))?'selected' : '' }}>{{ __('word.income.select_service') }}</option>
                            @foreach ($services as $item)
                                <option value="{{ $item->service_uuid }}"
                                        data-amount="{{ $item->amount }}"
                                        data-commission="{{ $item->commission }}"
                                @if(isset($service_uuid))
                                    {{ $item->service_uuid === $service_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 type="text" name="amounts[{{ $index }}]"
                                 value="{{ $amount ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.commission') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash-coin absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="commission-input focus-and-blur pl-9 pr-3 block w-full"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 type="text" name="commissions[{{ $index }}]"
                                 value="{{ $commission ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.quantity') }} *"/>
                    <div class="relative">
                        <i class="bi bi-stack absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                 inputmode="numeric" autocomplete="one-time-code"
                                 type="text" name="quantities[{{ $index }}]"
                                 value="{{ $quantity ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="method_uuids[{{ $index }}]"
                            onchange="update_input()">
                            <option value="" disabled
                                    data-name="None" {{ (!isset($method_uuid))?'selected' : '' }}>{{ __('word.income.select_method') }}</option>
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
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.bankregister_uuid') }}"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="bankregister_uuids[{{ $index }}]">
                            <option value=""
                                    data-name="None" {{ (!isset($bankregister_uuid))?'selected' : '' }}>{{ __('word.income.select_bankregister') }}</option>
                            @foreach ($bankregisters as $item)
                                <option value="{{ $item->bankregister_uuid }}"
                                        data-name="{{ $item->name }}"
                                @if(isset($bankregister_uuid))
                                    {{ $item->bankregister_uuid === $bankregister_uuid ? 'selected' : '' }}
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
            $array_code = $income->toArray()['codes'] ?? [];
            $array_service_uuids = $income->toArray()['service_uuids'] ?? [];
            $array_amounts = $income->toArray()['amounts'] ?? [];
            $array_commissions = $income->toArray()['commissions'] ?? [];
            $array_quantities = $income->toArray()['quantities'] ?? [];
            $array_method_uuids = $income->toArray()['method_uuids'] ?? [];
            $array_bankregister_uuids = $income->toArray()['bankregister_uuids'] ?? [];
            $max_update = max(count($array_code), count($array_service_uuids),count($array_amounts),count($array_commissions),count($array_quantities),count($array_method_uuids),count($array_bankregister_uuids));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $code = $array_code[$index] ?? null;
                    $service_uuid = $array_service_uuids[$index] ?? null;
                    $amount = $array_amounts[$index] ?? null;
                    $commission = $array_commissions[$index] ?? null;
                    $quantity = $array_quantities[$index] ?? null;
                    $method_uuid = $array_method_uuids[$index] ?? null;
                    $bankregister_uuid = $array_bankregister_uuids[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.code') }} "/>
                        <div class="relative">
                            <i class="bi bi-123 absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input class="first-element focus-and-blur pl-9 pr-3 block w-full" type="text"
                                     name="codes[{{ $index }}]"
                                     inputmode="text" autocomplete="one-time-code"
                                     value="{{ $code ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.service_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="service_uuids[{{ $index }}]"
                                    onchange="update_service()">
                                <option value="" disabled {{ (!isset($service_uuid))?'selected' : '' }}>{{ __('word.income.select_service') }}</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item->service_uuid }}"
                                            data-amount="{{ $item->amount }}"
                                            data-commission="{{ $item->commission }}"
                                    @if(isset($service_uuid))
                                        {{ $item->service_uuid === $service_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.amount') }} *"/>
                        <div class="relative">
                            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input onkeyup="update_amount()"
                                     class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="amounts[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $amount ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.commission') }}"/>
                        <div class="relative">
                            <i class="bi bi-cash-coin absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input onkeyup="update_amount()"
                                     class="commission-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="commissions[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $commission ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.quantity') }} *"/>
                        <div class="relative">
                            <i class="bi bi-stack absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input onkeyup="update_amount()"
                                     class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="quantities[{{ $index }}]"
                                     inputmode="numeric" autocomplete="one-time-code"
                                     value="{{ $quantity ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.method_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="method_uuids[{{ $index }}]"
                                    onchange="update_input()">
                                <option value="" disabled data-name="None" {{ (!isset($method_uuid))?'selected' : '' }}>{{ __('word.income.select_method') }}</option>
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
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.income.attribute.bankregister_uuid') }}"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="bankregister_uuids[{{ $index }}]">
                                <option value="" data-name="None" {{ (!isset($bankregister_uuid))?'selected' : '' }}>{{ __('word.income.select_bankregister') }}</option>
                                @foreach ($bankregisters as $item)
                                    <option value="{{ $item->bankregister_uuid }}"
                                            data-name="{{ $item->name }}"
                                    @if(isset($bankregister_uuid))
                                        {{ $item->bankregister_uuid === $bankregister_uuid ? 'selected' : '' }}
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
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.code') }} "/>
                    <div class="relative">
                        <i class="bi bi-123 absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="first-element focus-and-blur pl-9 pr-3 block w-full"
                                 inputmode="text" autocomplete="one-time-code" type="text" name="codes[0]"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.service_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="service_uuids[0]"
                            onchange="update_service()">
                            <option value="" disabled selected>{{ __('word.income.select_service') }}</option>
                            @foreach ($services as $item)
                                <option value="{{ $item->service_uuid }}"
                                        data-amount="{{ $item->amount }}"
                                        data-commission="{{ $item->commission }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amounts[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $income->amounts?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.commission') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash-coin absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="commission-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="commissions[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $income->commissions?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.quantity') }} *"/>
                    <div class="relative">
                        <i class="bi bi-stack absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input onkeyup="update_amount()"
                                 class="quantity-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="quantities[0]"
                                 inputmode="numeric" autocomplete="one-time-code"
                                 value="{{ $income->quantities?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.method_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="method-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="method_uuids[0]"
                            onchange="update_input()">
                            <option value="" disabled data-name="None"
                                    selected>{{ __('word.income.select_method') }}</option>
                            @foreach ($methods as $item)
                                <option value="{{ $item->method_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.income.attribute.bankregister_uuid') }}"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select
                            class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                            name="bankregister_uuids[0]">
                            <option value="" data-name="None"
                                    selected>{{ __('word.income.select_bankregister') }}</option>
                            @foreach ($bankregisters as $item)
                                <option value="{{ $item->bankregister_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@if($page === 'create')
    <div class="flex flex-wrap justify-evenly mt-6 space-y-4 sm:space-y-0">
        <div class="flex justify-center w-full sm:w-auto">
            <button type="button" id="add-row"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
            </button>
        </div>
        <div class="flex justify-center w-full sm:w-auto">
            <button type="button" id="remove-row"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg"
                    onclick="update_input()">
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
                update_input();
            });
        });
    </script>
@endif
