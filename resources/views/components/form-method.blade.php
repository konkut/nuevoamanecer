<div>
  <x-label for="name" value="{{ __('word.method.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $method->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description" value="{{ __('word.method.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="description" value="{{ old('description', $method->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
    <x-label for="bankregister_uuid" value="{{ __('word.method.attribute.bankregister_uuid') }} " />
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select id="bankregister_uuid"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="bankregister_uuid">
            <option value="" {{ old('bankregister_uuid', $method->bankregister_uuid) ? '' : 'selected' }}>
                {{__('word.method.select_bank')}}
            </option>
            @foreach($bankregisters as $item)
                <option value="{{ $item->bankregister_uuid }}" {{ (old('bankregister_uuid', $method->bankregister_uuid) == $item->bankregister_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
    @error('bankregister_uuid')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
