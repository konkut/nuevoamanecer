<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="bg-white shadow sm:rounded-lg pt-6 sm:pt-0">
            {{ $content }}
        </div>
    </div>
</div>
