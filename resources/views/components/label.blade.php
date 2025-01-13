@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-gray-600 pb-2 ']) }}>
    {{ $value ?? $slot }}
</label>
