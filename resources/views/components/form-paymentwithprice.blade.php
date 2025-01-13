<div class="mt-4">
    <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text"
                 name="observation" value="{{ old('observation', $paymentwithprice->observation ?? '') }}"/>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_names = old('names', []);
         $old_amounts = old('amounts', []);
         $old_commissions = old('commissions', []);
         $old_servicewithoutprice_uuids = old('servicewithoutprice_uuids', []);
         $old_transactionmethod_uuids = old('transactionmethod_uuids', []);
         $max_old = max(count($old_names), count($old_amounts), count($old_servicewithoutprice_uuids), count($old_transactionmethod_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $name = $old_names[$index] ?? null;
                 $amount = $old_amounts[$index] ?? null;
                 $commission = $old_commissions[$index] ?? null;
                 $servicewithoutprice_uuid = $old_servicewithoutprice_uuids[$index] ?? null;
                 $transactionmethod_uuid = $old_transactionmethod_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="name_{{ $name }}" value="{{ __('word.payment.attribute.name') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="name_{{ $name }}"
                                 class="focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text"
                                 name="names[{{ $index }}]"
                                 value="{{ $name ?? ''}}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="amount_{{ $amount }}" value="{{ __('word.payment.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="amount_{{ $amount }}"
                                 onkeyup="updateCharge_paymentwithprice()"
                                 class="amount-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text"
                                 name="amounts[{{ $index }}]"
                                 value="{{ $amount ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="commission_{{ $commission }}" value="{{ __('word.payment.attribute.commission') }}"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="commission_{{ $commission }}"
                                 onkeyup="updateCharge_paymentwithprice()"
                                 class="commission-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text"
                                 name="commissions[{{ $index }}]"
                                 value="{{ $commission ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="servicewithoutprice_uuid_{{ $servicewithoutprice_uuid }}"
                             value="{{ __('word.payment.attribute.servicewithoutprice_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="servicewithoutprice_uuid_{{ $servicewithoutprice_uuid }}"
                                class="service-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="servicewithoutprice_uuids[{{ $index }}]">
                            <option value="" disabled {{ (!isset($servicewithoutprice_uuid))?'selected' : '' }}>
                                {{ __('word.payment.select_service') }}
                            </option>
                            @foreach ($servicewithoutprices as $item)
                                <option value="{{ $item->servicewithoutprice_uuid }}"
                                @if(isset($servicewithoutprice_uuid))
                                    {{ $item->servicewithoutprice_uuid === $servicewithoutprice_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                             value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="transactionmethod_uuids[{{ $index }}]"
                                onchange="updateCharge_paymentwithprice()">
                            <option value="" disabled data-name="None" {{ (!isset($transactionmethod_uuid))?'selected' : '' }}>
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
             $array_names = $names;
             $array_amounts = $amounts;
             $array_commissions = $commissions;
             $array_services = $services;
             $array_methods = $methods;
             $max_update = max(count($array_names), count($array_amounts), count($array_commissions), count($array_services), count($array_methods));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $name = $names[$index] ?? null;
                    $amount = $amounts[$index] ?? null;
                    $commission = $commissions[$index] ?? null;
                    $servicewithoutprice_uuid = $array_services[$index] ?? null;
                    $transactionmethod_uuid = $array_methods[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label for="name_{{ $name }}" value="{{ __('word.payment.attribute.name') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input id="name_{{ $name }}"
                                     class="focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                     type="text"
                                     name="names[{{ $index }}]"
                                     value="{{ $name ?? ''}}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label for="amount_{{ $amount }}" value="{{ __('word.payment.attribute.amount') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input id="amount_{{ $amount }}"
                                     onkeyup="updateCharge_paymentwithprice()"
                                     class="amount-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                     type="text"
                                     name="amounts[{{ $index }}]"
                                     value="{{ $amount ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label for="commission_{{ $commission }}" value="{{ __('word.payment.attribute.commission') }}"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input id="commission_{{ $commission }}"
                                     onkeyup="updateCharge_paymentwithprice()"
                                     class="commission-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                     type="text"
                                     name="commissions[{{ $index }}]"
                                     value="{{ $commission ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 w-full sm:w-1/2">
                        <x-label for="servicewithoutprice_uuid_{{ $servicewithoutprice_uuid }}"
                                 value="{{ __('word.payment.attribute.servicewithoutprice_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select id="servicewithoutprice_uuid_{{ $servicewithoutprice_uuid }}"
                                    class="focus-and-blur service-select border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="servicewithoutprice_uuids[{{ $index }}]">
                                <option value="" disabled {{ (!isset($servicewithoutprice_uuid))?'selected' : '' }}>
                                    {{ __('word.payment.select_service') }}
                                </option>
                                @foreach($servicewithoutprices as $item)
                                    <option value="{{ $item->servicewithoutprice_uuid }}"
                                    @if(isset($servicewithoutprice_uuid))
                                        {{ $item->servicewithoutprice_uuid === $servicewithoutprice_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 w-full sm:w-1/2">
                        <x-label for="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                 value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select id="transactionmethod_uuid_{{ $transactionmethod_uuid }}"
                                    class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                    name="transactionmethod_uuids[{{ $index }}]"
                                    onchange="updateCharge_paymentwithprice()">
                                <option value="" disabled data-name="None" {{ (!isset($transactionmethod_uuid))?'selected' : '' }}>
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
                    <x-label for="name" value="{{ __('word.payment.attribute.name') }} *" />
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="name" class="focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full" type="text" name="names[0]" />
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="amount" value="{{ __('word.payment.attribute.amount') }} *" />
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="amount" onkeyup="updateCharge_paymentwithprice()"
                                 class="amount-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text" name="amounts[0]"
                                 value="{{ $paymentwithprice->amounts?? '' }}" />
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="commission" value="{{ __('word.payment.attribute.commission') }}" />
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="commission" onkeyup="updateCharge_paymentwithprice()"
                                 class="commission-input focus-and-blur pl-9 pr-3 py-2 block mt-1 w-full"
                                 type="text" name="commissions[0]"
                                 value="{{ $paymentwithprice->commissions?? '' }}" />
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="servicewithoutprice_uuid" value="{{ __('word.payment.attribute.servicewithoutprice_uuid') }} *" />
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="servicewithoutprice_uuid" onchange="updateCharge_paymentwithprice()"
                                class="focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="servicewithoutprice_uuids[0]">
                            <option value="" disabled selected>{{ __('word.payment.select_service') }}</option>
                            @foreach($servicewithoutprices as $item)
                                <option value="{{ $item->servicewithoutprice_uuid }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label for="transactionmethod_uuid" value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *" />
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="transactionmethod_uuid"
                                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                                name="transactionmethod_uuids[0]"
                                onchange="updateCharge_paymentwithprice()">
                            <option value="" disabled selected data-name="None">{{ __('word.payment.select_method') }}</option>
                            @foreach($transactionmethods as $item)
                                <option value="{{ $item->transactionmethod_uuid }}"
                                        data-name="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
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
                onclick="updateCharge_paymentwithprice()">
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
        // Quitar la última fila
        removeRowButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.row-template');
            if (rows.length > 1) {
                rows[rows.length - 1].remove(); // Quita la última fila si hay más de una
            }
            updateCharge_paymentwithprice();
        });
    });
</script>
