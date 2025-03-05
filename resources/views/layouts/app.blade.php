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
    <link rel="stylesheet" href="{{ url('css/app.css?v='.time()) }}">
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

<body class="font-sans antialiased">
<x-banner/>
<x-loader/>
<x-md_alert/>

<div class="min-h-screen bg-gray-100">
    <div class="flex flex-row w-full min-h-screen">
        <div class="justify-start min-w-72 bg-gray-800 text-white p-4 hidden" id="sidebar">
            <x-menu></x-menu>
        </div>
        <div class="flex flex-col w-full overflow-hidden">
            @livewire('navigation-menu')
            @if (isset($header))
                <header class="bg-blue-500 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-blue-100">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
@stack('modals')
@livewireScripts
{{ $js_files ?? '' }}
<script type="text/javascript">
    let button_sidebar = document.getElementById("sidebar_button");
    let sidebar = document.getElementById("sidebar");
    const computedStyle = window.getComputedStyle(sidebar);
    button_sidebar.addEventListener("click", e => {
        if (computedStyle.getPropertyValue("display") === "none") {
            sidebar.style.display = "block";
        } else {
            sidebar.style.display = "none";
        }
    })
</script>

</body>
</html>

