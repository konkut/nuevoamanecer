
<div class="mt-4">
  <x-label for="name" value="{{ __('word.payment.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $paymentwithprice->name?? '') }}" />
  </div>
</div>
<div class="mt-4">
    <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}" />
    <div class="relative">
        <i id="observation_icon" class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="pl-9 block mt-1 w-full" type="text" name="observation" value="{{ old('observation', $paymentwithprice->observation?? '') }}" />
    </div>
</div>
<div class="mt-4">
    <x-label for="amount" value="{{ __('word.payment.attribute.amount') }} *" />
    <div class="relative">
        <i id="amount_icon" class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="amount" onkeyup="updateCharge()" class="pl-9 block mt-1 w-full" type="text" name="amount" value="{{ old('amount', $paymentwithprice->amount?? '') }}" />
    </div>
</div>
<div class="mt-4">
    <x-label for="commission" value="{{ __('word.payment.attribute.commission') }}" />
    <div class="relative">
        <i id="commission_icon" class="bi bi-percent absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="commission" onkeyup="updateCharge()" class="pl-9 block mt-1 w-full" type="text" name="commission" value="{{ old('commission', $paymentwithprice->commission?? '') }}" />
    </div>
</div>

<div class="mt-4">
  <x-label for="servicewithoutprice_uuid" value="{{ __('word.payment.attribute.servicewithoutprice_uuid') }} *" />
  <div class="relative">
    <i id="servicewithoutprice_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <select id="servicewithoutprice_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="servicewithoutprice_uuid">
      <option value="{{ $paymentwithprice->servicewithoutprice_uuid }}"  disabled {{ old('servicewithoutprice_uuid', $paymentwithprice->servicewithoutprice_uuid) ? '' : 'selected' }}>
        {{__('word.payment.select_service')}}
      </option>
      @foreach($servicewithoutprices as $item)
      <option value="{{ $item->servicewithoutprice_uuid }}" {{ (old('servicewithoutprice_uuid', $paymentwithprice->servicewithoutprice_uuid) == $item->servicewithoutprice_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
</div>

<div class="mt-4">
  <x-label for="transactionmethod_uuid" value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *" />
  <div class="relative">
    <i id="transactionmethod_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <select id="transactionmethod_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="transactionmethod_uuid">
      <option value="" disabled {{ old('transactionmethod_uuid', $paymentwithprice->transactionmethod_uuid) ? '' : 'selected' }}>
        {{__('word.payment.select_method')}}
      </option>
      @foreach($transactionmethods as $item)
      <option value="{{ $item->transactionmethod_uuid }}" {{ (old('transactionmethod_uuid', $paymentwithprice->transactionmethod_uuid) == $item->transactionmethod_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
</div>
