<div class="mt-4">
  <x-label for="opening" value="{{ __('word.cashcount.attribute.opening') }} *" />
  <div class="relative">
    <i id="opening_icon" class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="opening" onkeyup="updateCharge_cashcount()" class="pl-9 block mt-1 w-full" type="text" name="opening" value="{{ old('opening', $cashcount->opening?? '') }}" />
  </div>
</div>
