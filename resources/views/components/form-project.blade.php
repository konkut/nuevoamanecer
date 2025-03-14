<div>
    <x-label for="name" value="{{ __('word.project.attribute.name') }} *"/>
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="name"
                 value="{{ old('name', $project->name?? '') }}"/>
    </div>
    @error('name')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="start_date" value="{{ __('word.project.attribute.start_date') }} *"/>
    <div class="relative">
        <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="start_date" class="focus-and-blur pl-9 block mt-1 w-full text-black appearance-auto"
                 type="date" name="start_date" value="{{ old('start_date', $project->start_date?? '') }}"/>
    </div>
    @error('start_date')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="end_date" value="{{ __('word.project.attribute.end_date') }} *"/>
    <div class="relative">
        <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="end_date" class="focus-and-blur pl-9 block mt-1 w-full"
                 type="date" name="end_date" value="{{ old('end_date', $project->end_date?? '') }}"/>
    </div>
    @error('end_date')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="description" value="{{ __('word.project.attribute.description') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="description"
                 value="{{ old('description', $project->description?? '') }}"/>
    </div>
    @error('description')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="budget" value="{{ __('word.project.attribute.budget') }} *" />
    <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="budget" class="focus-and-blur pl-9 block mt-1 w-full" type="text"
                 inputmode="decimal" autocomplete="one-time-code" name="budget" value="{{ old('budget', $project->budget?? '') }}" />
    </div>
    @error('budget')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="company_uuid" value="{{ __('word.project.attribute.company_uuid') }} *" />
    <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <select required id="company_uuid"
                class="focus-and-blur pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full"
                name="company_uuid">
            <option value="" disabled {{ old('company_uuid', $project->company_uuid) ? '' : 'selected' }}>
                {{__('word.project.select_company')}}
            </option>
            @foreach($companies as $item)
                <option value="{{ $item->company_uuid }}" {{ (old('company_uuid', $project->company_uuid) == $item->company_uuid) ? 'selected' : '' }}>
                    {{$item->name}}
                </option>
            @endforeach
        </select>
    </div>
    @error('company_uuid')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>


