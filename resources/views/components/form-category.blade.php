<div>
  <x-label for="name" value="{{ __('word.category.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $category->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.category.attribute.description') }}" />
  <div class="relative">
    <i id="description_icon" class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="description" class="pl-9 block mt-1 w-full" type="text" name="description" value="{{ old('description', $category->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>