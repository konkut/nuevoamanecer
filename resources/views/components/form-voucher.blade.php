<div class="grid grid-cols-1 md:grid-cols-5 gap-4 pb-8">
    <div class="mt-4 col-span-1">
        <x-label value="{{ __('word.voucher.attribute.number') }} *"/>
        <div class="relative">
            <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <div class="border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 pl-9 pr-3 py-2 shadow-sm rounded-md bg-gray-100">{{ $voucher->number }}</div>
            <input type="hidden"
                   name="number"
                   value="{{ $voucher->number }}">
        </div>
    </div>
    <div class="mt-4 col-span-1">
        <x-label value="{{ __('word.voucher.attribute.company_uuid') }} *"/>
        <div class="relative">
            <i class="bi-building absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <div class="border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 pl-9 pr-3 py-2 shadow-sm rounded-md bg-gray-100">{{ $voucher->name }}</div>
            <input type="hidden"
                   name="company_uuid"
                   value="{{ $voucher->company_uuid }}">
        </div>
    </div>
    <div class="mt-4 col-span-1">
        <x-label for="project_uuid" value="{{ __('word.voucher.attribute.project_uuid') }} *"/>
        <div class="relative">
            <i class="bi bi-kanban absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <select  id="project_uuid"
                    class="first-element focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                    name="project_uuid">
                <option value=""
                        disabled {{ old('project_uuid', $voucher->project_uuid) ? '' : 'selected' }}>{{__('word.voucher.select_project')}}</option>
                @foreach($projects as $item)
                    <option
                        value="{{ $item->project_uuid }}" {{ (old('project_uuid', $voucher->project_uuid) == $item->project_uuid) ? 'selected' : '' }}>
                        {{$item->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-4 col-span-1">
        <x-label for="date" value="{{ __('word.voucher.attribute.date') }} *"/>
        <div class="relative">
            <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input required id="date" class=" focus-and-blur pl-9 block mt-1 w-full"
                     type="date" name="date" value="{{ old('date', $voucher->date?? '') }}"/>
        </div>
    </div>
    <div class="mt-4 col-span-1">
        <x-label for="type" value="{{ __('word.voucher.attribute.type') }} *"/>
        <div class="relative">
            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <select required id="type"
                    class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                    name="type">
                <option value="" disabled {{ old('type', $voucher->type) ? '' : 'selected' }}>{{ __('word.voucher.select_type') }}</option>
                <option value="2" {{ old('type', $voucher->type) == 'income' ? 'selected' : '' }}>{{ __('word.voucher.income') }}</option>
                <option value="3" {{ old('type', $voucher->type) == 'expense' ? 'selected' : '' }}>{{ __('word.voucher.expense') }}</option>
                <option value="1" {{ old('type', $voucher->type) == 'transfer' ? 'selected' : '' }}>{{ __('word.voucher.transfer') }}</option>
            </select>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 pb-8">
    <div class="mt-4 col-span-3">
        <x-label for="narration" value="{{ __('word.voucher.attribute.narration') }}" />
        <div class="relative">
            <i class="bi-chat-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <x-input id="narration" class="focus-and-blur pl-9 block mt-1 w-full"
                     inputmode="text" autocomplete="one-time-code" type="text" name="narration" value="{{ old('narration', $voucher->narration?? '') }}" />
        </div>
    </div>
    <div class="mt-4 col-span-2">
       <div class="flex flex-row gap-4">
           <div>
               <x-label for="cheque_number" value="{{ __('word.voucher.attribute.cheque_number') }}"/>
               <div class="relative">
                   <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                   <x-input id="cheque_number" class="focus-and-blur pl-9 pr-3 block w-full"
                            type="text" name="cheque_number"
                            inputmode="decimal" autocomplete="one-time-code"
                            value="{{ old('cheque_number', $voucher->cheque_number?? '') }}"/>
               </div>
           </div>
           <div>
               <x-label for="ufv" value="{{ __('word.voucher.attribute.ufv') }}"/>
               <div class="relative">
                   <i class="bi-graph-up absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                   <x-input id="ufv" class="focus-and-blur pl-9 pr-3 block w-full"
                            type="text" name="ufv"
                            inputmode="decimal" autocomplete="one-time-code"
                            value="{{ old('ufv', $voucher->ufv?? '') }}"/>
               </div>
           </div>
           <div>
               <x-label for="usd" value="{{ __('word.voucher.attribute.usd') }}"/>
               <div class="relative">
                   <i class="bi-currency-dollar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                   <x-input id="usd" class="focus-and-blur pl-9 pr-3 block w-full"
                            type="text" name="usd"
                            inputmode="decimal" autocomplete="one-time-code"
                            value="{{ old('usd', $voucher->usd?? '') }}"/>
               </div>
           </div>
       </div>
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    @php
        $old_account_uuids = old('account_uuids', []);
        $old_debits = old('debits', []);
        $old_credits = old('credits', []);
        $max_old = max(count($old_account_uuids), count($old_debits), count($old_credits));
    @endphp
    @if (!empty($max_old))
        @for ($index = 0; $index < $max_old; $index++)
            @php
                $account_uuid = $old_account_uuids[$index] ?? null;
                $debit = $old_debits[$index] ?? null;
                $credit = $old_credits[$index] ?? null;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 pb-4 row-template">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.search') }}"/>
                    <div class="relative">
                        <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <input type="text"
                               onkeyup="search_account(this)"
                               data-index="{{ $index }}"
                               placeholder="{{ __('word.voucher.search') }} ..."
                               class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                    </div>
                </div>
                <div class="mt-4 md:col-span-2">
                    <x-label value="{{ __('word.voucher.attribute.account_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required name="account_uuids[{{ $index }}]" data-index="{{ $index }}"
                                class="select-account focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                            <option value=""
                                    disabled {{ (!isset($account_uuid))?'selected' : '' }}>{{ __('word.voucher.select_account') }}</option>
                            @foreach($accounts as $class)
                                <option value="" disabled>📁 {{ $class->code }} - {{ $class->name }}</option>
                                @foreach($class->groups as $group)
                                    <option value="" disabled>&nbsp;&nbsp;📂 {{ $group->code }}
                                        - {{ $group->name }}</option>
                                    @foreach($group->subgroups as $subgroup)
                                        <option value="" disabled>&nbsp;&nbsp;&nbsp;&nbsp;📑 {{ $subgroup->code }}
                                            - {{ $subgroup->name }}</option>
                                        @foreach($subgroup->accounts as $account)
                                            <option value="{{ $account->account_uuid }}"
                                            @if(isset($account_uuid))
                                                {{ $account->account_uuid === $account_uuid ? 'selected' : '' }}
                                                @endif>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📌 {{ $account->code }}
                                                - {{ $account->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.attribute.debit') }}"/>
                    <div class="relative">
                        <i class="bi-arrow-left-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="debit-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="debits[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 onkeyup="total_balance()"
                                 value="{{ $debit ?? '' }}"/>
                    </div>
                </div>
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.attribute.credit') }}"/>
                    <div class="relative">
                        <i class="bi-arrow-right-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="credit-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="credits[{{ $index }}]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 onkeyup="total_balance()"
                                 value="{{ $credit ?? '' }}"/>
                    </div>
                </div>
            </div>
        @endfor
    @else
        @php
            $array_account_uuids = $voucher->toArray()['account_uuids'] ?? [];
            $array_debits = $voucher->toArray()['debits'] ?? [];
            $array_credits = $voucher->toArray()['credits'] ?? [];
            $max_update = max(count($array_account_uuids), count($array_debits), count($array_credits));
        @endphp
        @if (!empty($max_update))
            @for ($index = 0; $index < $max_update; $index++)
                @php
                    $account_uuid = $array_account_uuids[$index] ?? null;
                    $debit = $array_debits[$index] ?? null;
                    $credit = $array_credits[$index] ?? null;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 pb-4 row-template">
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.voucher.search') }}"/>
                        <div class="relative">
                            <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <input type="text"
                                   onkeyup="search_account(this)"
                                   data-index="{{ $index }}"
                                   placeholder="{{ __('word.voucher.search') }} ..."
                                   class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                        </div>
                    </div>
                    <div class="mt-4 md:col-span-2">
                        <x-label value="{{ __('word.voucher.attribute.account_uuid') }} *"/>
                        <div class="relative">
                            <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <select required name="account_uuids[{{ $index }}]" data-index="{{ $index }}"
                                    class="select-account focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                                <option value=""
                                        disabled {{ (!isset($account_uuid))?'selected' : '' }}>{{ __('word.voucher.select_account') }}</option>
                                @foreach($accounts as $class)
                                    <option value="" disabled>📁 {{ $class->code }} - {{ $class->name }}</option>
                                    @foreach($class->groups as $group)
                                        <option value="" disabled>&nbsp;&nbsp;📂 {{ $group->code }}
                                            - {{ $group->name }}</option>
                                        @foreach($group->subgroups as $subgroup)
                                            <option value="" disabled>&nbsp;&nbsp;&nbsp;&nbsp;📑 {{ $subgroup->code }}
                                                - {{ $subgroup->name }}</option>
                                            @foreach($subgroup->accounts as $account)
                                                <option value="{{ $account->account_uuid }}"
                                                @if(isset($account_uuid))
                                                    {{ $account->account_uuid === $account_uuid ? 'selected' : '' }}
                                                    @endif>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📌 {{ $account->code }}
                                                    - {{ $account->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.voucher.attribute.debit') }}"/>
                        <div class="relative">
                            <i class="bi-arrow-left-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input class="debit-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="debits[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     onkeyup="total_balance()"
                                     value="{{ $debit ?? '' }}"/>
                        </div>
                    </div>
                    <div class="mt-4 md:col-span-1">
                        <x-label value="{{ __('word.voucher.attribute.credit') }}"/>
                        <div class="relative">
                            <i class="bi-arrow-right-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <x-input class="credit-input focus-and-blur pl-9 pr-3 block w-full"
                                     type="text" name="credits[{{ $index }}]"
                                     inputmode="decimal" autocomplete="one-time-code"
                                     onkeyup="total_balance()"
                                     value="{{ $credit ?? '' }}"/>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 pb-4 row-template">
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.search') }}"/>
                    <div class="relative">
                        <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <input type="text"
                               onkeyup="search_account(this)"
                               placeholder="{{ __('word.voucher.search') }} ..."
                               data-index="0"
                               class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                    </div>
                </div>
                <div class="mt-4 md:col-span-2">
                    <x-label value="{{ __('word.voucher.attribute.account_uuid') }} *"/>
                    <div class="relative">
                        <i class="bi-journal-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <select required name="account_uuids[0]" data-index="0"
                                class="select-account focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                            <option value="" disabled selected>{{ __('word.voucher.select_account') }}</option>
                            @foreach($accounts as $class)
                                <option value="" disabled>📁 {{ $class->code }} - {{ $class->name }}</option>
                                @foreach($class->groups as $group)
                                    <option value="" disabled>&nbsp;&nbsp;📂 {{ $group->code }} - {{ $group->name }}</option>
                                    @foreach($group->subgroups as $subgroup)
                                        <option value="" disabled>&nbsp;&nbsp;&nbsp;&nbsp;📑 {{ $subgroup->code }} - {{ $subgroup->name }}</option>
                                        @foreach($subgroup->accounts as $account)
                                            <option value="{{ $account->account_uuid }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;📌 {{ $account->code }} - {{ $account->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.attribute.debit') }}"/>
                    <div class="relative">
                        <i class="bi-arrow-left-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="debit-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="debits[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 onkeyup="total_balance()"
                                 value="{{ $voucher->debit ?? '' }}"
                        />
                    </div>
                </div>
                <div class="mt-4 md:col-span-1">
                    <x-label value="{{ __('word.voucher.attribute.credit') }}"/>
                    <div class="relative">
                        <i class="bi-arrow-right-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input class="credit-input focus-and-blur pl-9 pr-3 block w-full"
                                 type="text" name="credits[0]"
                                 inputmode="decimal" autocomplete="one-time-code"
                                 onkeyup="total_balance()"
                                 value="{{ $voucher->credit ?? '' }}"
                        />
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-5 gap-4 py-4 ">
    <p class="md:col-span-3 flex justify-end items-center text-sm text-slate-600">{{ __('word.voucher.difference') }} &nbsp;&nbsp; <b class="text-lg mb-0.5" id="total_difference"></b></p>
    <div id="total_debit" class="md:col-span-1 flex justify-center items-center py-2.5 overflow-hidden cursor-default text-center font-bold text-yellow-600 bg-yellow-100 border-0 rounded-lg shadow-md"
    >{{ "0.00" }}</div>
    <div id="total_credit" class="md:col-span-1 flex justify-center items-center py-2.5 overflow-hidden cursor-default text-center font-bold text-yellow-600 bg-yellow-100 border-0 rounded-lg shadow-md"
    >{{ "0.00" }}</div>
</div>

@if($page === 'create')
    <div class="flex flex-col md:flex-row md:justify-evenly my-6 space-y-4 md:space-y-0">
        <div class="flex justify-center">
            <button type="button" id="add-row"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-plus mr-2"></i>{{ __('word.voucher.add_account') }}
            </button>
        </div>
        <div class="flex justify-center">
            <button type="button" id="remove-row"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
                <i class="bi bi-dash mr-2"></i>{{ __('word.voucher.delete_account') }}
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
                    if(select.getAttribute('data-index')){
                        select.setAttribute('data-index', newIndex);
                    }
                });
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = ''
                    const name = input.getAttribute('name');
                    if (name) {
                        const updatedName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                        input.setAttribute('name', updatedName);
                    }
                    if(input.getAttribute('data-index')){
                        input.setAttribute('data-index', newIndex);
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
        });
    </script>
@endif



