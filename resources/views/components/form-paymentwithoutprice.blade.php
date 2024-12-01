
<div class="mt-4">
  <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}" />
  <div class="relative">
    <i id="observation_icon" class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="observation" class="pl-9 block mt-1 w-full" type="text" name="observation" value="{{ old('observation', $paymentwithoutprice->observation?? '') }}" />
  </div>
</div>

<div class="mt-4">
  <x-label for="servicewithprice_uuid" value="{{ __('word.payment.attribute.servicewithprice_uuid') }} *" />
  <div class="relative">
    <i id="servicewithprice_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <select id="servicewithprice_uuid" onchange="updateCharge()" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="servicewithprice_uuid">
      <option value="{{ $paymentwithoutprice->servicewithprice_uuid }}"  disabled {{ old('servicewithprice_uuid', $paymentwithoutprice->servicewithprice_uuid) ? '' : 'selected' }}>
        {{__('word.payment.select_service')}}
      </option>
      @foreach($servicewithprices as $item)
      <option value="{{ $item->servicewithprice_uuid }}" data-amount="{{ $item->amount }}" data-commission="{{ $item->commission }}" {{ (old('servicewithprice_uuid', $paymentwithoutprice->servicewithprice_uuid) == $item->servicewithprice_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
  @error('servicewithprice_uuid')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>

<div class="mt-4">
  <x-label for="transactionmethod_uuid" value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *" />
  <div class="relative">
    <i id="transactionmethod_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <select id="transactionmethod_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="transactionmethod_uuid">
      <option value="" disabled {{ old('transactionmethod_uuid', $paymentwithoutprice->transactionmethod_uuid) ? '' : 'selected' }}>
        {{__('word.payment.select_method')}}
      </option>
      @foreach($transactionmethods as $item)
      <option value="{{ $item->transactionmethod_uuid }}" {{ (old('transactionmethod_uuid', $paymentwithoutprice->transactionmethod_uuid) == $item->transactionmethod_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
  @error('transactionmethod_uuid')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
