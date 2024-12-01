@props(['disabled' => false])


<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm']) !!}>

