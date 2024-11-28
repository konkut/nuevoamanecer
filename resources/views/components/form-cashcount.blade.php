<div class="mt-4">
  <x-label for="opening" value="{{ __('word.cashcount.attribute.opening') }} *" />
  <div class="relative">
    <i id="opening_icon" class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="opening" class="pl-9 block mt-1 w-full" type="text" name="opening" value="{{ old('opening', $cashcount->opening?? '') }}" />
  </div>
  @error('opening')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>