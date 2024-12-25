@if($allfields)
    <div class="mt-4">
        <x-label for="cashregister_uuid" value="{{ __('word.cashshift.attribute.cashregister_uuid') }} *"/>
        <div class="relative">
            <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
            <select id="cashregister_uuid"
                    class="first-element focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full"
                    name="cashregister_uuid"
                    onchange="fetchData(this.value)">
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
<div class="mt-4">
    <x-label for="initial_balance" value="{{ __('word.cashshift.attribute.initial_balance') }} *"/>
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="initial_balance" onkeyup="updateChargeFromCashshift()"
                 class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="initial_balance"
                 value="{{ old('initial_balance', $cashshift->initial_balance?? '') }}"/>
    </div>
</div>

<div class="mt-4">
    <x-label for="start_time" value="{{ __('word.cashshift.attribute.start_time') }} *"/>
    <div class="relative">
        <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="start_time" class="focus-and-blur pl-9 block mt-1 w-full" type="date" name="start_time"
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

