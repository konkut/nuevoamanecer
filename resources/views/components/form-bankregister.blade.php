<div class="mt-4">
    <x-label for="name" value="{{ __('word.bankregister.attribute.name') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="name"
                 class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="name" value="{{ old('name', $bankregister->name?? '') }}" />
    </div>
</div>
@error('name')
<small class="font-bold text-red-500/80">{{ $message }}</small>
@enderror
<div class="mt-4">
  <x-label for="total" value="{{ __('word.bankregister.attribute.total') }} *" />
  <div class="relative">
    <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="total"
             class="focus-and-blur pl-9 block mt-1 w-full"
             type="text" name="total" value="{{ old('total', $bankregister->total?? '') }}" />
  </div>
</div>
@error('total')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
<div class="mt-4">
    <x-label for="owner_name" value="{{ __('word.bankregister.attribute.owner_name') }} *" />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="owner_name"
                 class="focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="owner_name" value="{{ old('owner_name', $bankregister->owner_name?? '') }}" />
    </div>
</div>
@error('owner_name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
<div class="mt-4">
    <x-label for="account_number" value="{{ __('word.bankregister.attribute.account_number') }} " />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="account_number"
                 class="focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="account_number" value="{{ old('account_number', $bankregister->account_number?? '') }}" />
    </div>
</div>
@error('account_number')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
