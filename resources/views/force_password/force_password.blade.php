<x-guest-layout>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/password/show-password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/password/message_password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/password/random_password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/force_password/fetch_force_password.js?v='.time()) }}"></script>
    </x-slot>
    @if (session('warning'))
        <x-alert-warning :message="session('warning')"/>
    @endif
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex justify-center pb-4">
                <img src="{{ asset('images/logo.png') }}" class="w-28" alt="Logo">
            </div>
        </x-slot>
        <form method="POST" action="{{ route('password.change.update') }}" onsubmit="fetch_force_password(this, '{{url('/')}}', event)">
            @csrf
            <x-form-force-password-change></x-form-force-password-change>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

