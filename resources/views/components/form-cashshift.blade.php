<div class="grid grid-cols-1 md:grid-cols-3 gap-4 pb-8">
    <div class="mt-4">
        <x-label for="start_time" value="{{ __('word.cashshift.attribute.start_time') }} *"/>
        <div class="relative">
            <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input id="start_time" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="date"
                     name="start_time"
                     value="{{ old('start_time', $cashshift->start_time?? '') }}"/>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="end_time" value="{{ __('word.cashshift.attribute.end_time') }} "/>
        <div class="relative">
            <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input id="end_time" class="focus-and-blur pl-9 block mt-1 w-full" type="date" name="end_time"
                     value="{{ old('end_time', $cashshift->end_time?? '') }}"/>
        </div>
    </div>
    @if($allfields)
        <div class="mt-4">
            <x-label for="user_id" value="{{ __('word.cashshift.attribute.user_id') }} *"/>
            <div class="relative">
                <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <select id="user_id"
                        class="focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                        name="user_id">
                    <option value="" disabled {{ old('user_id', $cashshift->user_id) ? '' : 'selected' }}>
                        {{__('word.cashshift.select_user')}}
                    </option>
                    @foreach($users as $item)
                        <option
                            value="{{ $item->id }}" {{ (old('user_id', $cashshift->user_id) == $item->id) ? 'selected' : '' }}>
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4">
    @if($allfields)
        <div class="mt-4 md:col-span-1">
            <x-label for="cashregister_uuid" value="{{ __('word.cashshift.attribute.cashregister_uuid') }} *"/>
            <div class="relative">
                <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <select id="cashregister_uuid"
                        class="focus-and-blur w-full border-t border-b border-[#d1d5db] pl-9 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400"
                        name="cashregister_uuid"
                        onchange="fetch_data(this.value)">
                    <option value=""
                            disabled {{ old('cashregister_uuid', $cashshift->cashregister_uuid) ? '' : 'selected' }}>
                        {{__('word.cashshift.select_cashregister')}}
                    </option>
                    @foreach($cashregisters as $item)
                        <option
                            value="{{ $item->cashregister_uuid }}" {{ (old('cashregister_uuid', $cashshift->cashregister_uuid) == $item->cashregister_uuid) ? 'selected' : '' }}>
                            {{$item->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @foreach($cashregisters as $item)
            <a id="data-form-{{ $item->cashregister_uuid }}"
               href="{{ route('cashshifts.data', $item->cashregister_uuid) }}"
               style="display: none;">
            </a>
        @endforeach
        <div class="mt-4 md:col-span-1">
            <x-label for="initial_balance" value="{{ __('word.cashshift.attribute.balance') }} *"/>
            <div class="relative">
                <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <x-input id="initial_balance" onkeyup="updateChargeFromCashshift()"
                         class="focus-and-blur pl-9 w-full" type="text" name="initial_balance"
                         value="{{ old('initial_balance', $cashshift->initial_balance?? '') }}"/>
            </div>
        </div>
    @endif
</div>
@if($allfields)
    <div id="dynamic-rows-container" class="flex flex-col space-y-4">
        @php
            $old_balances = old('balances', []);
             $old_bankregister_uuids = old('bankregister_uuids', []);
             $max_old = max(count($old_balances), count($old_bankregister_uuids));
        @endphp
        @if (!empty($max_old))
            @for ($index = 0; $index < $max_old; $index++)
                @php
                    $balances = $old_balances[$index] ?? null;
                     $bankregister_uuid= $old_bankregister_uuids[$index] ?? null;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template">
                    <div class="mt-4 md:col-span-1">
                        <x-label for="bankregister_uuid_{{ $bankregister_uuid }}"
                                 value="{{ __('word.cashshift.attribute.bankregister_uuids') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select id="bankregister_uuid_{{ $bankregister_uuid }}"
                                    class="bank-select w-full focus-and-blur border-t border-b border-[#d1d5db] pl-9 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400"
                                    name="bankregister_uuids[{{ $index }}]"
                                    onchange="fetch_balance(this.value)">
                                <option value="" disabled
                                        data-name="None" {{ (!isset($bankregister_uuid))?'selected' : '' }}>
                                    {{ __('word.cashshift.select_bankregister') }}
                                </option>
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
                    @foreach($bankregisters as $item)
                        <a id="balance-form-{{ $item->bankregister_uuid }}"
                           href="{{ route('cashshifts.balance', $item->bankregister_uuid) }}"
                           style="display: none;">
                        </a>
                    @endforeach
                    <div class="mt-4 md:col-span-1">
                        <x-label for="balances_{{ $balances }}" value="{{ __('word.cashshift.attribute.balances') }}"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input id="balances_{{ $balances }}"
                                     class="balance-input focus-and-blur pl-9 w-full"
                                     type="text"
                                     name="balances[{{ $index }}]"
                                     value="{{ $balances ?? '' }}"/>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template">
                <div class="mt-4 md:col-span-1">
                    <x-label for="bankregister_uuid" value="{{ __('word.cashshift.attribute.bankregister_uuids') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select id="bankregister_uuid"
                                class="bank-select focus-and-blur w-full border-t border-b border-[#d1d5db] pl-9 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400"
                                name="bankregister_uuids[0]"
                                onchange="fetch_balance(this.value)">
                            <option value="" disabled selected
                                    data-name="None">{{ __('word.cashshift.select_bankregister') }}</option>
                            @foreach($bankregisters as $item)
                                <option value="{{ $item->bankregister_uuid }}"
                                        data-name="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($bankregisters as $item)
                    <a id="balance-form-{{ $item->bankregister_uuid }}"
                       href="{{ route('cashshifts.balance', $item->bankregister_uuid) }}"
                       style="display: none;">
                    </a>
                @endforeach
                <div class="mt-4 md:col-span-1">
                    <x-label for="balances" value="{{ __('word.cashshift.attribute.balances') }}"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="balances"
                                 class="balance-input focus-and-blur pl-9 w-full"
                                 type="text" name="balances[0]"
                                 value="{{ $cashshift->balances?? '' }}"/>
                    </div>
                </div>
            </div>
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
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
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
                    rows[rows.length - 1].remove(); // Quita la última fila si hay más de una
                }
            });
        });
    </script>
@endif

