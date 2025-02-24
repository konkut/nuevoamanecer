@if($page == "edit")
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">{{ __('word.account.attribute.code') }}</label>
        <p id="code-{{$accountclass->accountclass_uuid}}" class="mt-1 p-2 bg-gray-100 text-gray-800 rounded-md border border-gray-300">
        </p>
    </div>
@endif
<div>
  <x-label for="accountclass-{{$accountclass->accountclass_uuid}}" value="{{ __('word.account.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input required id="accountclass-{{$accountclass->accountclass_uuid}}"
             class="{{ $page == 'edit' ? 'first-element-'.$accountclass->accountclass_uuid : 'first-element-accountclass' }} focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $accountclass->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description-{{$accountclass->accountclass_uuid}}" value="{{ __('word.account.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description-{{$accountclass->accountclass_uuid}}" class="focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="description" value="{{ old('description', $accountclass->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
