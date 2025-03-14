<div>
    <x-label for="name" value="{{ __('word.company.attribute.name') }} *"/>
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="name"
                 value="{{ old('name', $company->name?? '') }}"/>
    </div>
    @error('name')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="nit" value="{{ __('word.company.attribute.nit') }} *" />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="nit"
                 inputmode="numeric" autocomplete="one-time-code"
                 class="focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="nit" value="{{ old('nit', $company->nit?? '') }}" />
    </div>
    @error('nit')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="description" value="{{ __('word.company.attribute.description') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="description"
                 value="{{ old('description', $company->description?? '') }}"/>
    </div>
    @error('description')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="businesstype_uuid" value="{{ __('word.company.attribute.businesstype_uuid') }} *" />
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="businesstype_uuid"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="businesstype_uuid">
            <option value="" disabled {{ old('businesstype_uuid', $company->businesstype_uuid) ? '' : 'selected' }}>
                {{__('word.company.select_business')}}
            </option>
            @foreach($businesstypes as $item)
                <option value="{{ $item->businesstype_uuid }}" {{ (old('businesstype_uuid', $company->businesstype_uuid) == $item->businesstype_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
    @error('businesstype_uuid')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="activity_uuid" value="{{ __('word.company.attribute.activity_uuid') }} *" />
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="activity_uuid"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="activity_uuid">
            <option value="" disabled {{ old('activity_uuid', $company->activity_uuid) ? '' : 'selected' }}>
                {{__('word.company.select_activity')}}
            </option>
            @foreach($activities as $item)
                <option value="{{ $item->activity_uuid }}" {{ (old('activity_uuid', $company->activity_uuid) == $item->activity_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
    @error('activity_uuid')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
