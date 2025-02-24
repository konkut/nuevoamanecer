<div>
    <x-label for="name" value="{{ __('word.activity.attribute.name') }} *"/>
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="name"
                 value="{{ old('name', $activity->name?? '') }}"/>
    </div>
    @error('name')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="start_date" value="{{ __('word.activity.attribute.start') }} *"/>
    <div class="relative">
        <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="start_date" class="focus-and-blur pl-9 block mt-1 w-full"
                 type="date" name="start_date" value="{{ old('start_date', $activity->start_date?? '') }}"/>
    </div>
    @error('start_date')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="end_date" value="{{ __('word.activity.attribute.end') }} *"/>
    <div class="relative">
        <i class="bi bi-calendar absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="end_date" class="focus-and-blur pl-9 block mt-1 w-full"
                 type="date" name="end_date" value="{{ old('end_date', $activity->end_date?? '') }}"/>
    </div>
    @error('end_date')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="description" value="{{ __('word.activity.attribute.description') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="description" class="focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="description"
                 value="{{ old('description', $activity->description?? '') }}"/>
    </div>
    @error('description')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>

