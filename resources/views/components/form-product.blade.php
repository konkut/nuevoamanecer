<div>
  <x-label for="name" value="{{ __('word.product.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $product->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.product.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="description" value="{{ old('description', $product->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="price" value="{{ __('word.product.attribute.price') }} *" />
  <div class="relative">
    <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="price" class="focus-and-blur pl-9 block mt-1 w-full" type="text"
             inputmode="decimal" autocomplete="one-time-code" name="price" value="{{ old('price', $product->price?? '') }}" />
  </div>
  @error('price')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
    <x-label for="stock" value="{{ __('word.product.attribute.stock') }} *" />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="stock" class="focus-and-blur pl-9 block mt-1 w-full" type="text"
                 inputmode="numeric" autocomplete="one-time-code" name="stock" value="{{ old('stock', $product->stock?? '') }}" />
    </div>
    @error('stock')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
  <x-label for="category_uuid" value="{{ __('word.product.attribute.category_uuid') }} *" />
  <div class="relative">
    <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <select id="category_uuid" class="focus-and-blur border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="category_uuid">
      <option value="" disabled {{ old('category_uuid', $product->category_uuid) ? '' : 'selected' }}>
        {{__('word.service.select_category')}}
      </option>
      @foreach($categories as $item)
      <option value="{{ $item->category_uuid }}" {{ (old('category_uuid', $product->category_uuid) == $item->category_uuid) ? 'selected' : '' }}>
        {{$item->name}}
      </option>
      @endforeach
    </select>
  </div>
  @error('category_uuid')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
