<div>
  <x-label for="name" value="{{ __('word.currency.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $currency->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="symbol" value="{{ __('word.currency.attribute.symbol') }}" />
  <div class="relative">
    <i id="symbol_icon" class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="symbol" class="pl-9 block mt-1 w-full" type="text" name="symbol" value="{{ old('symbol', $currency->symbol?? '') }}" />
  </div>
  @error('symbol')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="exchange_rate" value="{{ __('word.currency.attribute.exchange_rate') }} " />
  <div class="relative">
    <i id="exchange_rate_icon" class="bi bi-currency-exchange absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="exchange_rate" class="pl-9 block mt-1 w-full" type="text" name="exchange_rate" value="{{ old('exchange_rate', $currency->exchange_rate?? '') }}" />
  </div>
  @error('exchange_rate')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>