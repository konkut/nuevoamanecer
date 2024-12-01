<div>
  <x-label for="name" value="{{ __('word.service.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $servicewithoutprice->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.service.attribute.description') }}" />
  <div class="relative">
    <i id="description_icon" class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="description" class="pl-9 block mt-1 w-full" type="text" name="description" value="{{ old('description', $servicewithoutprice->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="category_uuid" value="{{ __('word.service.attribute.category_uuid') }} *" />
  <div class="relative">
    <i id="category_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <select id="category_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="category_uuid">
      <option value="" disabled {{ old('category_uuid', $servicewithoutprice->category_uuid) ? '' : 'selected' }}>
        {{__('word.service.select_category')}}
      </option>
      @foreach($categories as $item)
      <option value="{{ $item->category_uuid }}" {{ (old('category_uuid', $servicewithoutprice->category_uuid) == $item->category_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
  @error('category_uuid')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
