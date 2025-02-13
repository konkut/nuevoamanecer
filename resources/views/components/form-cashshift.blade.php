<div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-8">
    <div class="mt-4">
        <x-label for="start_time" value="{{ __('word.cashshift.attribute.start_time') }} *"/>
        <div class="relative">
            <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input required id="start_time" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                     type="datetime-local"
                     name="start_time" value="{{ old('start_time', $cashshift->start_time?? '') }}"/>
        </div>
    </div>
    <div class="mt-4">
        <x-label for="end_time" value="{{ __('word.cashshift.attribute.end_time') }} "/>
        <div class="relative">
            <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input id="end_time" class="focus-and-blur pl-9 block mt-1 w-full" type="datetime-local" name="end_time"
                     value="{{ old('end_time', $cashshift->end_time?? '') }}"/>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-1 gap-4 pb-8">
    <div class="mt-4">
        <x-label for="user_id" value="{{ __('word.cashshift.attribute.user_id') }} *"/>
        <div class="relative">
            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <select required id="user_id"
                    class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                    name="user_id">
                <option value=""
                        disabled {{ old('user_id', $cashshift->user_id) ? '' : 'selected' }}>{{__('word.cashshift.select_user')}}</option>
                @foreach($users as $item)
                    <option
                        value="{{ $item->id }}" {{ (old('user_id', $cashshift->user_id) == $item->id) ? 'selected' : '' }}>
                        {{$item->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4">
    <div class="mt-4 md:col-span-1">
        <x-label for="cashregister_uuid" value="{{ __('word.cashshift.attribute.cashregister_uuid') }} *"/>
        <div class="relative">
            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <select required id="cashregister_uuid"
                    class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                    name="cashregister_uuid" onchange="fetch_price_cashshift(this.value)">
                <option value=""
                        disabled {{ old('cashregister_uuid', $cashshift->cashregister_uuid) ? '' : 'selected' }}>
                    {{__('word.cashshift.select_cashregister')}}
                </option>
                @foreach($cashregisters as $item)
                    <option
                        value="{{ $item->cashregister_uuid }}"
                        {{ (old('cashregister_uuid', $cashshift->cashregister_uuid) == $item->cashregister_uuid) ? 'selected' : '' }}>
                        {{$item->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @foreach($cashregisters as $item)
        <a id="price-form-{{ $item->cashregister_uuid }}"
           href="{{ route('cashshifts.price', $item->cashregister_uuid) }}"
           style="display: none;">
        </a>
    @endforeach
    <div class="mt-4 md:col-span-1">
        <x-label for="price" value="{{ __('word.cashshift.attribute.price') }} *"/>
        <div class="relative">
            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input required id="price" onkeyup="update_price_cashshift()"
                     inputmode="decimal" autocomplete="one-time-code"
                     class="focus-and-blur pl-9 w-full" type="text" name="price_cash"
                     value="{{ old('price_cash', $cashshift->price?? '') }}"/>
        </div>
    </div>

</div>

<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_amounts = old('amount_bank', []);
        $old_bankregister_uuids = old('bankregister_uuids', []);
        $max_old = max(count($old_amounts), count($old_bankregister_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $amount = $old_amounts[$index] ?? null;
                $bankregister_uuid = $old_bankregister_uuids[$index] ?? null;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.bankregister_uuids') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="bankregister_uuids[{{ $index }}]"
                                onchange="fetch_amount_cashshift(this.value)">
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
                    <a id="amount-form-{{ $item->bankregister_uuid }}"
                       href="{{ route('cashshifts.amount', $item->bankregister_uuid) }}"
                       style="display: none;">
                    </a>
                @endforeach
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.amount') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amount_bank[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $amount == 0 ? '' : (float) number_format($amount, 2, '.', '') }}"/>
                    </div>
                </div>
            </div>
        @endfor
    @else
        @php
            $array_amounts = $cashshift->toArray()['amounts'] ?? [];
            $array_bankregister_uuids = $cashshift->toArray()['bankregister_uuids'] ?? [];
            $max_update = max(count($array_amounts), count($array_bankregister_uuids));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $amount = $array_amounts[$index] ?? null;
                    $bankregister_uuid = $array_bankregister_uuids[$index] ?? null;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template">
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.cashshift.attribute.bankregister_uuids') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="bankregister_uuids[{{ $index }}]"
                                    onchange="fetch_amount_cashshift(this.value)">
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
                        <a id="amount-form-{{ $item->bankregister_uuid }}"
                           href="{{ route('cashshifts.amount', $item->bankregister_uuid) }}"
                           style="display: none;">
                        </a>
                    @endforeach
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.cashshift.attribute.amount') }}"/>
                        <div class="relative">
                            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input required class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="amount_bank[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $amount == 0 ? '' : (float) number_format($amount, 2, '.', '') }}"/>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.bankregister_uuids') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="bank-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="bankregister_uuids[0]"
                                onchange="fetch_amount_cashshift(this.value)">
                            <option value="" disabled data-name="None"
                                    selected>{{ __('word.cashshift.select_bankregister') }}</option>
                            @foreach ($bankregisters as $item)
                                <option value="{{ $item->bankregister_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($bankregisters as $item)
                    <a id="amount-form-{{ $item->bankregister_uuid }}"
                       href="{{ route('cashshifts.amount', $item->bankregister_uuid) }}"
                       style="display: none;">
                    </a>
                @endforeach
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.amount') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amount_bank[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $cashshift->amounts == 0 ? '' : (float) number_format($cashshift->amounts, 2, '.', '') }}"/>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

@if($page === 'create')
    <div class="flex flex-col md:flex-row md:justify-evenly my-6 space-y-4 md:space-y-0">
        <div class="flex justify-center">
            <button type="button" id="add-row"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-plus mr-2"></i>{{ __('word.general.add_row_bank') }}
            </button>
        </div>
        <div class="flex justify-center">
            <button type="button" id="remove-row"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-dash mr-2"></i>{{ __('word.general.delete_row_bank') }}
            </button>
        </div>
    </div>
@endif
<div id="dynamic-rows-box" class="flex flex-col space-y-4">
    @php
        $old_values = old('amount_platform', []);
        $old_platform_uuids = old('platform_uuids', []);
        $max_old = max(count($old_values), count($old_platform_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $value = $old_values[$index] ?? null;
                $platform_uuid = $old_platform_uuids[$index] ?? null;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template-box">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.platform_uuids') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="platform-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="platform_uuids[{{ $index }}]"
                                onchange="fetch_value_cashshift(this.value)">
                            <option value="" disabled
                                    data-name="None" {{ (!isset($platform_uuid))?'selected' : '' }}>
                                {{ __('word.cashshift.select_platform') }}
                            </option>
                            @foreach ($platforms as $item)
                                <option value="{{ $item->platform_uuid }}"
                                        data-name="{{ $item->name }}"
                                @if(isset($platform_uuid))
                                    {{ $item->platform_uuid === $platform_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($platforms as $item)
                    <a id="value-form-{{ $item->platform_uuid }}"
                       href="{{ route('cashshifts.value', $item->platform_uuid) }}"
                       style="display: none;">
                    </a>
                @endforeach
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.value') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required class="value-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amount_platform[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $value == 0 ? '' : (float) number_format($value, 2, '.', '') }}"/>
                    </div>
                </div>
            </div>
        @endfor
    @else
        @php
            $array_values = $cashshift->toArray()['values'] ?? [];
            $array_platform_uuids = $cashshift->toArray()['platform_uuids'] ?? [];
            $max_update = max(count($array_values), count($array_platform_uuids));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $value = $array_values[$index] ?? null;
                    $platform_uuid = $array_platform_uuids[$index] ?? null;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template-box">
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.cashshift.attribute.platform_uuids') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="platform-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="platform_uuids[{{ $index }}]"
                                    onchange="fetch_value_cashshift(this.value)">
                                <option value="" disabled
                                        data-name="None" {{ (!isset($platform_uuid))?'selected' : '' }}>
                                    {{ __('word.cashshift.select_platform') }}
                                </option>
                                @foreach ($platforms as $item)
                                    <option value="{{ $item->platform_uuid }}"
                                            data-name="{{ $item->name }}"
                                    @if(isset($platform_uuid))
                                        {{ $item->platform_uuid === $platform_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @foreach($platforms as $item)
                        <a id="value-form-{{ $item->platform_uuid }}"
                           href="{{ route('cashshifts.value', $item->platform_uuid) }}"
                           style="display: none;">
                        </a>
                    @endforeach
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.cashshift.attribute.value') }}"/>
                        <div class="relative">
                            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input required class="value-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="amount_platform[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $value == 0 ? '' : (float) number_format($value, 2, '.', '') }}"/>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 row-template-box">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.platform_uuids') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="platform-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="platform_uuids[0]"
                                onchange="fetch_value_cashshift(this.value)">
                            <option value="" disabled data-name="None"
                                    selected>{{ __('word.cashshift.select_platform') }}</option>
                            @foreach ($platforms as $item)
                                <option value="{{ $item->platform_uuid }}"
                                        data-name="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @foreach($platforms as $item)
                    <a id="value-form-{{ $item->platform_uuid }}"
                       href="{{ route('cashshifts.value', $item->platform_uuid) }}"
                       style="display: none;">
                    </a>
                @endforeach
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.cashshift.attribute.value') }}"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required class="value-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amount_platform[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $cashshift->values == 0 ? '' : (float) number_format($cashshift->values, 2, '.', '') }}"/>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

@if($page === 'create')
    <div class="flex flex-col md:flex-row md:justify-evenly mt-6 space-y-4 md:space-y-0">
        <div class="flex justify-center">
            <button type="button" id="add-row-box"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-plus mr-2"></i>{{ __('word.general.add_row_platform') }}
            </button>
        </div>
        <div class="flex justify-center">
            <button type="button" id="remove-row-box"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-dash mr-2"></i>{{ __('word.general.delete_row_platform') }}
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('dynamic-rows-container');
            const addRowButton = document.getElementById('add-row');
            const removeRowButton = document.getElementById('remove-row');
            const box = document.getElementById('dynamic-rows-box');
            const addRowButtonBox = document.getElementById('add-row-box');
            const removeRowButtonBox = document.getElementById('remove-row-box');
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
            });
            addRowButtonBox.addEventListener('click', function () {
                const template = document.querySelector('.row-template-box');
                const newIndex = box.children.length;
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
                box.appendChild(newRow);
            });
            removeRowButtonBox.addEventListener('click', function () {
                const rows = box.querySelectorAll('.row-template-box');
                if (rows.length > 1) {
                    rows[rows.length - 1].remove();
                }
            });
        });
    </script>
@endif

