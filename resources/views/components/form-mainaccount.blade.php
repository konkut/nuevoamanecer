@if($page == "edit")
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">{{ __('word.account.attribute.code') }}</label>
        <p id="code-{{$mainaccount->mainaccount_uuid}}" class="mt-1 p-2 bg-gray-100 text-gray-800 rounded-md border border-gray-300"></p>
    </div>
@endif
<div>
  <x-label for="mainaccount-{{$mainaccount->mainaccount_uuid}}" value="{{ __('word.account.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input required id="mainaccount-{{$mainaccount->mainaccount_uuid}}"
             class="{{ $page == 'edit' ? 'first-element-'.$mainaccount->mainaccount_uuid : 'first-element-mainaccount' }} focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $mainaccount->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
  <x-label for="description-{{$mainaccount->mainaccount_uuid}}" value="{{ __('word.account.attribute.description') }}" />
  <div class="relative">
    <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input id="description-{{$mainaccount->mainaccount_uuid}}" class="focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="description" value="{{ old('description', $mainaccount->description?? '') }}" />
  </div>
  @error('description')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
    <x-label for="accountsubgroup_uuid-{{$mainaccount->mainaccount_uuid}}" value="{{ __('word.account.attribute.accountsubgroup_uuid') }} *" />
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="accountsubgroup_uuid-{{$mainaccount->mainaccount_uuid}}"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="accountsubgroup_uuid">
            <option value="" disabled selected>{{__('word.mainaccount.select_accountsubgroup')}}</option>
            @foreach($allaccountsubgroups as $item)
                <option value="{{ $item->accountsubgroup_uuid }}">{{$item->name}}</option>
            @endforeach
        </select>
    </div>
    @error('accountsubgroup_uuid')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>

