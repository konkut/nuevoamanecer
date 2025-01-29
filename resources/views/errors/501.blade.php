<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <link rel="shortcut icon" href="{{url('images/icono.ico')}}" type="image/x-icon">
    <!--Meta -->
    <title>{{ $title ?? __('word.general.app') }} - {{__('word.error.501.title')}}</title>
    <meta name="description" content="{{ $metaDescription ?? __('word.general.app') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? __('word.general.app') }}">
    <meta name="author" content="{{ $metaAuthor ?? __('word.general.author') }}">
    <meta property="og:title" content="{{ $metaOgTitle ?? __('word.general.app') }}">
    <meta property="og:description" content="{{ $metaOgDescription ?? __('word.general.app') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col justify-center items-center min-h-screen bg-gray-900 text-white p-8">
<a href="{{ route('dashboard') }}" class="mb-6 hover:opacity-80 transition-opacity duration-300">
    <img class="w-24 h-24" src="{{ asset('images/logo.png') }}" alt="Ingresar a la página">
</a>
<div class="text-center">
    <h1 class="text-2xl font-bold mb-2">{{__('word.error.501.title')}}</h1>
    <p class="text-gray-300 text-md mb-4">{{__('word.error.501.subtitle')}}</p>
    <a href="{{ route('dashboard') }}" title="{{__('word.general.title_icon_home')}}"
       class="inline-block px-6 py-3 text-sm font-semibold text-gray-900 bg-yellow-400 rounded-lg hover:bg-yellow-500 transition-all duration-300">
        {{__('word.error.home')}}
    </a>
</div>
<div class="mt-8">
    <img class="max-w-full h-auto object-contain" src="{{ asset('images/error/501.jpg') }}" alt="Error 501">
</div>
</body>
</html>
