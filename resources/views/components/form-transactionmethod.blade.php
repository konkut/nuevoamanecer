<div>
  <x-label for="name" value="{{ __('word.transactionmethod.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $transactionmethod->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
    <x-label for="balance" value="{{ __('word.transactionmethod.attribute.balance') }} " />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="balance" class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="balance" value="{{ old('balance', $transactionmethod->balance?? '') }}" />
    </div>
    @error('balance')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.transactionmethod.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="description" value="{{ old('description', $transactionmethod->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
