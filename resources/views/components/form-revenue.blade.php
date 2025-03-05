<div class="mt-4">
    <x-label for="observation" value="{{ __('word.revenue.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 type="text" inputmode="text" autocomplete="one-time-code"
                 name="observation" value="{{ old('observation', $revenue->observation?? '') }}"/>
    </div>
</div>
<div class="mt-4">
    <x-label value="{{ __('word.revenue.attribute.customer_uuid') }} *"/>
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="customer_uuid">
            <option value="" disabled {{ (!isset($revenue->customer_uuid))?'selected' : '' }}>{{ __('word.revenue.select_customer') }}</option>
            @foreach ($customers as $item)
                <option
                    value="{{ $item->customer_uuid }}" {{ (old('customer_uuid', $revenue->customer_uuid) == $item->customer_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_service_uuids = old('service_uuids', []);
        $old_amounts = old('amounts', []);
        $old_charge_uuids = old('charge_uuids', []);
        $max_old = max(count($old_service_uuids), count($old_amounts), count($old_charge_uuids));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $service_uuid = $old_service_uuids[$index] ?? null;
                $amount = $old_amounts[$index] ?? null;
                $charge_uuid = $old_charge_uuids[$index] ?? null;
            @endphp
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.revenue.attribute.service_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="service_uuids[{{ $index }}]"
                                onchange="update_amount(this)">
                            <option value="" disabled {{ (!isset($service_uuid))?'selected' : '' }}>{{ __('word.revenue.select_service') }}</option>
                            @foreach ($services as $item)
                                <option value="{{ $item->service_uuid }}"
                                        data-price="{{ $item->amount }}"
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
                    <x-label value="{{ __('word.revenue.attribute.charge_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="charge-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="charge_uuids[{{ $index }}]"
                                onchange="update_amount(this)">
                            <option value="" disabled data-name="None" {{ (!isset($charge_uuid))?'selected' : '' }}>{{ __('word.revenue.select_charge') }}</option>
                            @foreach ($data as $item)
                                <option value="{{ $item->reference_uuid }}"
                                        data-name="{{ $item->pivot }}"
                                @if(isset($charge_uuid))
                                    {{ $item->reference_uuid === $charge_uuid ? 'selected' : '' }}
                                    @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.revenue.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required onkeyup="update_amount(this)"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amounts[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 value="{{ $amount ?? '' }}"/>
                    </div>
                </div>
            </div>
        @endfor
    @else
        @php
            $array_service_uuids = $revenue->toArray()['service_uuids'] ?? [];
            $array_amounts = $revenue->toArray()['amounts'] ?? [];
            $array_charge_uuids = $revenue->toArray()['charge_uuids'] ?? [];
            $max_update = max(count($array_service_uuids),count($array_amounts),count($array_charge_uuids));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $service_uuid = $array_service_uuids[$index] ?? null;
                    $amount = $array_amounts[$index] ?? null;
                    $charge_uuid = $array_charge_uuids[$index] ?? null;
                @endphp
                <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.revenue.attribute.service_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="service_uuids[{{ $index }}]"
                                    onchange="update_amount(this)">
                                <option value="" disabled {{ (!isset($service_uuid))?'selected' : '' }}>{{ __('word.revenue.select_service') }}</option>
                                @foreach ($services as $item)
                                    <option value="{{ $item->service_uuid }}"
                                            data-price="{{ $item->amount }}"
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
                        <x-label value="{{ __('word.revenue.attribute.charge_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required
                                    class="charge-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                    name="charge_uuids[{{ $index }}]"
                                    onchange="update_amount(this)">
                                <option value="" disabled data-name="None" {{ (!isset($charge_uuid))?'selected' : '' }}>{{ __('word.revenue.select_charge') }}</option>
                                @foreach ($data as $item)
                                    <option value="{{ $item->reference_uuid }}"
                                            data-name="{{ $item->pivot }}"
                                    @if(isset($charge_uuid))
                                        {{ $item->reference_uuid === $charge_uuid ? 'selected' : '' }}
                                        @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 w-full md:w-1/2">
                        <x-label value="{{ __('word.revenue.attribute.amount') }} *"/>
                        <div class="relative">
                            <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input required onkeyup="update_amount(this)"
                                     class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="amounts[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     value="{{ $amount ?? '' }}"/>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="flex flex-col md:flex-row md:space-x-4 row-template">
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.revenue.attribute.service_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="service-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="service_uuids[0]"
                                onchange="update_amount(this)">
                            <option value="" disabled selected>{{ __('word.revenue.select_service') }}</option>
                            @foreach ($services as $item)
                                <option value="{{ $item->service_uuid }}"
                                        data-price="{{ $item->amount }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.revenue.attribute.charge_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required
                                class="charge-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                                name="charge_uuids[0]"
                                onchange="update_amount(this)">
                            <option value="" disabled data-name="None" selected>{{ __('word.revenue.select_charge') }}</option>
                            @foreach ($data as $item)
                                <option value="{{ $item->reference_uuid }}"
                                        data-name="{{ $item->pivot }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 w-full md:w-1/2">
                    <x-label value="{{ __('word.revenue.attribute.amount') }} *"/>
                    <div class="relative">
                        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input required onkeyup="update_amount(this)"
                                 class="amount-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="amounts[0]"
                                 inputmode="decimal" autocomplete="one-time-code"/>
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
                <i class="bi bi-plus mr-2"></i>{{ __('word.general.add_service') }}
            </button>
        </div>
        <div class="flex justify-center w-full sm:w-auto">
            <button type="button" id="remove-row"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-dash mr-2"></i>{{ __('word.general.delete_service') }}
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
                    update_amount();
                }
            });
        });
    </script>
@endif

