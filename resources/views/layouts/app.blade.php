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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{ url('css/components/alert.css?v='.time()) }}">
    <script type="text/javascript" src="{{ url('js/app.js?v='.time()) }}"></script>

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

<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')

    <div class="flex flex-row w-full min-h-screen ">
        <div class="justify-start hidden sm:w-[350px] bg-white" id="sidebar">
            <div>
                <div class="shrink-0 flex items-center justify-center " >
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('/images/logo.png') }}" alt="Logo Nuevo Amanecer" class="block h-12 w-auto">
                    </a>
                </div>
                <nav class="flex-1 overflow-y-auto">
                    <ul class="space-y-1">
                        <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                        @can('users.index')
                            <x-responsive-nav-link href="{{ route('users.index') }}"
                                                   :active="request()->routeIs('users.index')">
                                {{ __('word.user.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        @can('categories.index')
                            <x-responsive-nav-link href="{{ route('categories.index') }}"
                                                   :active="request()->routeIs('categories.index')">
                                {{ __('word.category.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        @can('transactionmethods.index')
                            <x-responsive-nav-link href="{{ route('transactionmethods.index') }}"
                                                   :active="request()->routeIs('transactionmethods.index')">
                                {{ __('word.transactionmethod.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        <x-responsive-nav-link href="{{ route('serviceswithoutprices.index') }}"
                                               :active="request()->routeIs('serviceswithoutprices.index')">
                            {{ __('word.service.title_service_without_price') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('paymentwithprices.index') }}"
                                               :active="request()->routeIs('paymentwithprices.index')">
                            {{ __('word.payment.title_others') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('serviceswithprices.index') }}"
                                               :active="request()->routeIs('serviceswithprices.index')">
                            {{ __('word.service.title_service_with_price') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link href="{{ route('paymentwithoutprices.index') }}"
                                               :active="request()->routeIs('paymentwithoutprices.index')">
                            {{ __('word.payment.title') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link href="{{ route('cashcounts.index') }}"
                                               :active="request()->routeIs('cashcounts.index')">
                            {{ __('word.cashcount.title') }}
                        </x-responsive-nav-link>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="flex flex-col w-full">
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
<script type="text/javascript" >
    let button_sidebar = document.getElementById("sidebar_button");
    let sidebar = document.getElementById("sidebar");
    const computedStyle = window.getComputedStyle(sidebar);
    button_sidebar.addEventListener("click",e=>{
        if (computedStyle.getPropertyValue("display") === "none") {
            sidebar.style.display = "block";
        } else {
            sidebar.style.display = "none";
        }
    })
</script>
</body>
</html>
