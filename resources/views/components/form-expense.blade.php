<div class="mt-4">
    <x-label for="amount" value="{{ __('word.expense.attribute.amount') }} *"/>
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="amount" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="amount"
                 onkeyup="update_charge_expense()" inputmode="decimal" autocomplete="one-time-code"
                 value="{{ old('amount', $expense->amount?? '') }}"/>
    </div>
</div>
<div class="mt-4">
    <x-label for="observation" value="{{ __('word.expense.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="observation" inputmode="text" autocomplete="one-time-code"
                 value="{{ old('observation', $expense->observation?? '') }}"/>
    </div>
</div>
<div class="mt-4">
    <x-label for="category_uuid" value="{{ __('word.expense.attribute.category_uuid') }} *"/>
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="category_uuid"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="category_uuid">
            <option value="" disabled {{ old('category_uuid', $expense->category_uuid) ? '' : 'selected' }}>
                {{__('word.expense.select_category')}}
            </option>
            @foreach($categories as $item)
                <option
                    value="{{ $item->category_uuid }}" {{ (old('category_uuid', $expense->category_uuid) == $item->category_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-4">
    <x-label for="charge_uuid" value="{{ __('word.expense.attribute.charge_uuid') }} *"/>
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="charge_uuid"
                class="charge-select focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="charge_uuid"
                onchange="update_charge_expense()">
            <option value=""
                    disabled data-name="None" {{ old('charge_uuid', $expense->charge_uuid) ? '' : 'selected' }}>
                {{__('word.expense.select_charge')}}
            </option>
            @foreach($data as $item)
                <option
                    data-name="{{ $item->pivot }}"
                    value="{{ $item->reference_uuid }}" {{ (old('charge_uuid', $expense->charge_uuid) == $item->reference_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
