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

<body class="font-sans antialiased">
<x-banner/>
<x-loader/>
<x-md_alert />
<div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu')

    <div class="flex flex-row w-full min-h-screen ">
        <div class="justify-start hidden min-w-72 bg-white" id="sidebar">
            <div>
                <div class="shrink-0 flex items-center justify-center ">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('/images/logo.png') }}" alt="Logo Nuevo Amanecer" class="block h-12 w-auto">
                    </a>
                </div>
                <nav class="flex-1 overflow-y-auto">
                    <ul class="space-y-1">
                        <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                        @can('cashregisters.index')
                            <x-responsive-nav-link href="{{ route('cashregisters.index') }}"
                                                   :active="request()->routeIs('cashregisters.index')">
                                {{ __('word.cashregister.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        @can('users.index')
                            <x-responsive-nav-link href="{{ route('users.index') }}"
                                                   :active="request()->routeIs('users.index')">
                                {{ __('word.user.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        @can('bankregisters.index')
                            <x-responsive-nav-link href="{{ route('bankregisters.index') }}"
                                                   :active="request()->routeIs('bankregisters.index')">
                                {{ __('word.bankregister.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        {{--
                        @can('cashflowdailies.index')
                            <x-responsive-nav-link href="{{ route('cashflowdailies.index') }}"
                                                   :active="request()->routeIs('cashflowdailies.index')">
                                {{ __('word.cashflowdaily.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        --}}
                        <x-responsive-nav-link href="{{ route('cashshifts.index') }}"
                                               :active="request()->routeIs('cashshifts.index')">
                            {{ __('word.cashshift.title') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('incomes.index') }}"
                                               :active="request()->routeIs('incomes.index')">
                            {{ __('word.income.title') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('expenses.index') }}"
                                               :active="request()->routeIs('expenses.index')">
                            {{ __('word.expense.title') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('sales.index') }}"
                                               :active="request()->routeIs('sales.index')">
                            {{ __('word.sale.title') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('products.index') }}"
                                               :active="request()->routeIs('products.index')">
                            {{ __('word.product.title') }}
                        </x-responsive-nav-link>
                        @can('categories.index')
                            <x-responsive-nav-link href="{{ route('categories.index') }}"
                                                   :active="request()->routeIs('categories.index')">
                                {{ __('word.category.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        <x-responsive-nav-link href="{{ route('services.index') }}"
                                               :active="request()->routeIs('services.index')">
                            {{ __('word.service.title') }}
                        </x-responsive-nav-link>
                        @can('platforms.index')
                            <x-responsive-nav-link href="{{ route('platforms.index') }}"
                                                   :active="request()->routeIs('platforms.index')">
                                {{ __('word.platform.title') }}
                            </x-responsive-nav-link>
                        @endcan
                        <x-responsive-nav-link href="{{ route('receipts.index') }}"
                                               :active="request()->routeIs('receipts.index')">
                            {{ __('word.receipt.title') }}
                        </x-responsive-nav-link>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="flex flex-col w-full overflow-hidden">
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
