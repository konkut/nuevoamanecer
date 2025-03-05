<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--AQUI-->
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!--AQUI-->
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <link rel="shortcut icon" href="{{url('images/icono.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('css/components/alert.css?v='.time()) }}">
    <script type="text/javascript" src="{{ url('js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ url('js/app.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ url('js/loader.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ url('js/md_alert.js?v='.time()) }}"></script>
    <!--Meta -->
    <title>{{ $title ?? __('word.general.app') }} - {{__('word.general.app')}}</title>
    <meta name="description" content="{{ $metaDescription ?? __('word.general.app') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? __('word.general.app') }}">
    <meta name="author" content="{{ $metaAuthor ?? __('word.general.author') }}">
    <meta property="og:title" content="{{ $metaOgTitle ?? __('word.general.app') }}">
    <meta property="og:description" content="{{ $metaOgDescription ?? __('word.general.app') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

</head>

<body>
<x-loader/>
<x-md_alert/>
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>

@livewireScripts
{{ $js_files ?? '' }}
</body>

</html>
