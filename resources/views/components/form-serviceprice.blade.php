<div>
  <x-label for="name" value="{{ __('word.service.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $serviceprice->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.service.attribute.description') }}" />
  <div class="relative">
    <i id="description_icon" class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="description" class="pl-9 block mt-1 w-full" type="text" name="description" value="{{ old('description', $serviceprice->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>

<div class="mt-4">
  <x-label for="amount" value="{{ __('word.service.attribute.amount') }} *" />
  <div class="relative">
    <i id="amount_icon" class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="amount" class="pl-9 block mt-1 w-full" type="text" name="amount" value="{{ old('amount', $serviceprice->amount?? '') }}" />
  </div>
  @error('amount')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="commission" value="{{ __('word.service.attribute.commission') }}" />
  <div class="relative">
    <i id="commission_icon" class="bi bi-percent absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="commission" class="pl-9 block mt-1 w-full" type="text" name="commission" value="{{ old('commission', $serviceprice->commission?? '') }}" />
  </div>
  @error('commission')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>