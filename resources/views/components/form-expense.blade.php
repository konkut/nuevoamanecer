<div class="mt-4">
    <x-label for="amount" value="{{ __('word.expense.attribute.amount') }} *"/>
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="amount" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="amount"
                 onkeyup="updateCharge_expense()"
                 value="{{ old('amount', $expense->amount?? '') }}"/>
    </div>
</div>
<div class="mt-4">
    <x-label for="observation" value="{{ __('word.expense.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="observation"
                 value="{{ old('observation', $expense->observation?? '') }}"/>
    </div>
</div>

<div class="mt-4">
    <x-label for="category_uuid" value="{{ __('word.expense.attribute.category_uuid') }} *"/>
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select id="category_uuid"
                class="focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
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
    <x-label for="transactionmethod_uuid" value="{{ __('word.expense.attribute.transactionmethod_uuid') }} *"/>
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select id="transactionmethod_uuid"
                class="method-select focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                name="transactionmethod_uuid"
                onchange="updateCharge_expense()">
            <option value=""
                    disabled data-name="None" {{ old('transactionmethod_uuid', $expense->transactionmethod_uuid) ? '' : 'selected' }}>
                {{__('word.expense.select_method')}}
            </option>
            @foreach($transactionmethods as $item)
                <option
                    data-name="{{ $item->name }}"
                    value="{{ $item->transactionmethod_uuid }}" {{ (old('transactionmethod_uuid', $expense->transactionmethod_uuid) == $item->transactionmethod_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
</div>
