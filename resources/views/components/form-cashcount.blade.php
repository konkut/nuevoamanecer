<div class="mt-4">
    <x-label for="observation" value="{{ __('word.cashshift.attribute.observation') }}"/>
    <div class="relative">
        <i class="bi bi-card-text absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation"
                 class="focus-and-blur pl-9 block mt-1 w-full"
                 type="text" name="observation"
                 value="{{ old('observation', $cashshift->observation?? '') }}" />
    </div>
</div>
