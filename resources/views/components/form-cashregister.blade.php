<div class="mt-4">
    <x-label for="name" value="{{ __('word.cashregister.attribute.name') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $cashregister->name?? '') }}" />
    </div>
</div>

