@props(['active'])

@php
$classes = 'flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-150 ease-in-out text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
