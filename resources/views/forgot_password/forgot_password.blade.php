<x-guest-layout>
  <x-slot name="js_files">
      <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
      <script type="text/javascript" src="{{ asset('/js/forgot_password/fetch_forgot_password.js?v='.time()) }}"></script>
  </x-slot>
  <x-authentication-card>
    <x-slot name="logo">
      <div class="w-1/6 mx-auto pb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
      </div>
    </x-slot>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
      {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    <form method="POST" action="{{ route('password.email') }}" onsubmit="fetch_forgot_password(this, '{{url('/')}}', event)">
      @csrf
      <div class="block">
        <x-label for="email" value="{{ __('Email') }}" />
        <div class="relative">
          <i class="bi bi-envelope-open absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <x-input id="email" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>
      </div>
      <div class="flex items-center justify-end mt-4">
        <x-button>
          {{ __('Email Password Reset Link') }}
        </x-button>
      </div>
    </form>
  </x-authentication-card>
</x-guest-layout>
