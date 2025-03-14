<div>
  <x-label for="name" value="{{ __('word.businesstype.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $businesstype->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.businesstype.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="description" value="{{ old('description', $businesstype->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
