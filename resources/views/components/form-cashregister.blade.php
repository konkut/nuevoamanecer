<div class="mt-4">
    <x-label for="name" value="{{ __('word.cashregister.attribute.name') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $cashregister->name?? '') }}" />
    </div>
</div>
<div class="mt-4">
  <x-label for="initial_balance" value="{{ __('word.cashregister.attribute.initial_balance') }} *" />
  <div class="relative">
    <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="initial_balance" onkeyup="updateChargeFromCashregister()" class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="initial_balance" value="{{ old('initial_balance', $cashregister->initial_balance?? '') }}" />
  </div>
</div>
