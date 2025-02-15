<x-guest-layout>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/password/show-password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/two_factor/fetch_one_factor.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/password/message_password.js?v='.time()) }}"></script>
    </x-slot>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex justify-center pb-4">
                <img src="{{ asset('images/logo.png') }}" class="w-28" alt="Logo">
            </div>
        </x-slot>
        @if (session('success'))
            <x-alert :message="session('success')"/>
        @endif
        <form method="POST" action="{{ route('login') }}" onsubmit="fetch_one_factor(this, '{{url('/')}}', event)">
            @csrf
            <div>
                <x-label for="email" value="{{ __('Email') }}"/>
                <div class="relative">
                    <i class="bi bi-envelope-open absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
                    <x-input id="email" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="email"
                             name="email" :value="old('email')" required autofocus autocomplete="username"/>
                </div>
            </div>
            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Password') }}"/>
                <div class="relative">
                    <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                    <x-input id="password" class="focus-and-blur pl-9 block mt-1 w-full" type="password" name="password"
                             required autocomplete="current-password"/>
                    <x-box-password></x-box-password>
                </div>
            </div>
            <a href="javascript:void(0)"
               class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
               onclick="change_state_password(this)"
               data-state="hide" data-target="password">{{ __('word.general.show_password') }}</a>
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember"/>
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

