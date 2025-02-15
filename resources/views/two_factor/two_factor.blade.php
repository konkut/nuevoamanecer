<x-guest-layout>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/two_factor/fetch_two_factor.js?v='.time()) }}"></script>
    </x-slot>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="w-1/6 mx-auto">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
        </x-slot>
        <div>
            <x-validation-errors class="mb-4"/>
            <form method="POST" action="{{ route('verify_two_factor') }}" onsubmit="fetch_two_factor(this, '{{url('/')}}', event)">
                @csrf
                <div class="mt-4">
                    <x-label for="auth_code" value="{{ __('word.two_factor.code') }}"/>
                    <div class="relative">
                        <i class="bi bi-key-fill absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
                        <x-input id="auth_code" class="block mt-1 w-full first-element focus-and-blur pl-9" type="text" name="auth_code" autofocus inputmode="numeric" autocomplete="one-time-code"/>
                    </div>
                </div>
                <div class="mb-4 text-sm text-gray-600 pt-6">{{ __('word.two_factor.message') }}</div>
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('connect_two_factor') }}" class="text-sm text-[#60A5FA] font-bold underline cursor-pointer">
                        {{ __('word.two_factor.request') }}
                    </a>
                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
