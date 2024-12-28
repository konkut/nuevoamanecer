<div class="mt-4">
    <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text"
                 name="observation" value="{{ old('observation', $paymentwithoutprice->observation?? '') }}"/>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_quantities = old('quantities', []);
        $old_servicewithprice_uuids = old('servicewithprice_uuids', []);
        $old_transactionmethod_uuids = old('transactionmethod_uuids', []);
        $max_old = max(count($old_quantities),count($old_servicewithprice_uuids), count($old_transactionmethod_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $quantities = $old_quantities[$index] ?? null;
                $servicewithprice_uuid = $old_servicewithprice_uuids[$index] ?? null;
                $transactionmethod_uuid = $old_transactionmethod_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="servicewithprice_uuid_{{ $servicewithprice_uuid }}"
                             value="{{ __('word.payment.attribute.servicewithprice_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="servicewithprice_uuid_{{ $servicewithprice_uuid }}"
                                class="service-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="servicewithprice_uuids[]"
                                onchange="updateCharge_paymentwithoutprice()">
                            <option value="" disabled {{ (!isset($servicewithprice_uuid))?'selected' : '' }}>
                                {{ __('word.payment.select_service') }}
                            </option>
                            @foreach ($servicewithprices as $item)
                                <option value="{{ $item->servicewithprice_uuid }}"
                                        data-amount="{{ $item->amount }}"
                                        data-commission="{{ $item->commission }}"
                                @if(isset($servicewithprice_uuid))
                                    {{ $item->servicewithprice_uuid === $servicewithprice_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="quantities_{{ $quantities }}"
                             value="{{ __('word.payment.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="quantities_{{ $quantities }}"
                                 onkeyup="updateCharge_paymentwithoutprice()"
                                 class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text"
                                 name="quantities[]"
                                 value="{{ $quantities ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                             value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="transactionmethod_uuids[]"
                                onchange="updateCharge_paymentwithoutprice()">
                            <option value="" disabled
                                    data-name="None" {{ (!isset($transactionmethod_uuid))?'selected' : '' }}>
                                {{ __('word.payment.select_method') }}
                            </option>
                            @foreach ($transactionmethods as $item)
                                <option value="{{ $item->transactionmethod_uuid }}"
                                        data-name="{{ $item->name }}"
                                @if(isset($transactionmethod_uuid))
                                    {{ $item->transactionmethod_uuid === $transactionmethod_uuid ? 'selected' : '' }}
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
            $array_quantities = $quantities;
           $array_services = $services;
           $array_methods = $methods;
           $max_update = max(count($array_quantities), count($array_services), count($array_methods));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $quantity = $array_quantities[$index] ?? null;
                    $servicewithprice_uuid = $array_services[$index] ?? null;
                    $transactionmethod_uuid = $array_methods[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full sm:w-1/2">
                        <x-label for="servicewithprice_uuid_{{ $servicewithprice_uuid }}"
                                 value="{{ __('word.payment.attribute.servicewithprice_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select id="servicewithprice_uuid_{{ $servicewithprice_uuid }}"
                                    onchange="updateCharge_paymentwithoutprice()"
                                    class="focus-and-blur service-select border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="servicewithprice_uuids[]">
                                <option value="" disabled {{ (!isset($servicewithprice_uuid))?'selected' : '' }}>
                                    {{ __('word.payment.select_service') }}
                                </option>
                                @foreach($servicewithprices as $item)
                                    <option value="{{ $item->servicewithprice_uuid }}"
                                            data-amount="{{ $item->amount }}"
                                            data-commission="{{ $item->commission }}"
                                    @if(isset($servicewithprice_uuid))
                                        {{ $item->servicewithprice_uuid === $servicewithprice_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label for="quantities_{{$quantity}}" value="{{ __('word.payment.attribute.quantities') }} *"/>
                        <div class="relative">
                            <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input id="quantities_{{$quantity}}"
                                     onkeyup="updateCharge_paymentwithoutprice()"
                                     class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                     type="text" name="quantities[]"
                                     value="{{ $quantity ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full sm:w-1/2">
                        <x-label for="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                 value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select id="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                    class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="transactionmethod_uuids[]"
                                    onchange="updateCharge_paymentwithoutprice()">
                                <option value="" disabled
                                        data-name="None" {{ (!isset($transactionmethod_uuid))?'selected' : '' }}>
                                    {{ __('word.payment.select_method') }}
                                </option>
                                @foreach($transactionmethods as $item)
                                    <option value="{{ $item->transactionmethod_uuid }}"
                                            data-name="{{ $item->name }}"
                                    @if(isset($transactionmethod_uuid))
                                        {{ $item->transactionmethod_uuid === $transactionmethod_uuid ? 'selected' : '' }}
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
                    <x-label for="servicewithprice_uuid"
                             value="{{ __('word.payment.attribute.servicewithprice_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="servicewithprice_uuid"
                                class="service-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="servicewithprice_uuids[]"
                                onchange="updateCharge_paymentwithoutprice()">
                            <option value="" disabled selected>{{ __('word.payment.select_service') }}</option>
                            @foreach ($servicewithprices as $item)
                                <option value="{{ $item->servicewithprice_uuid }}"
                                        data-amount="{{ $item->amount }}"
                                        data-commission="{{ $item->commission }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="quantities" value="{{ __('word.payment.attribute.quantities') }} *"/>
                    <div class="relative">
                        <i class="bi bi-grid-3x3-gap-fill absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="quantities"
                                 onkeyup="updateCharge_paymentwithoutprice()"
                                 class="quantities-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text" name="quantities[]"
                                 value="{{ $paymentwithoutprice->quantities?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="transactionmethod_uuid"
                             value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="transactionmethod_uuid"
                                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="transactionmethod_uuids[]"
                                onchange="updateCharge_paymentwithoutprice()">
                            <option value="" disabled data-name="None"
                                    selected>{{ __('word.payment.select_method') }}</option>
                            @foreach ($transactionmethods as $item)
                                <option value="{{ $item->transactionmethod_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
<div class="flex flex-wrap justify-evenly mt-6 space-y-4 sm:space-y-0">
    <div class="flex justify-center w-full sm:w-auto">
        <!-- Botón para agregar fila -->
        <button type="button" id="add-row"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
            <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
        </button>
    </div>
    <div class="flex justify-center w-full sm:w-auto">
        <!-- Botón para quitar fila -->
        <button type="button" id="remove-row"
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg"
                onclick="updateCharge_paymentwithoutprice()">
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
            const newRow = template.cloneNode(true);
            newRow.querySelectorAll('select').forEach(select => select.value = '');
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            container.appendChild(newRow);
        });
        // Quitar la última fila
        removeRowButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.row-template');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
            }
            updateCharge_paymentwithoutprice();
        });
    });
</script>
