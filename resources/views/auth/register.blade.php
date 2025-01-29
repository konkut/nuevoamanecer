<x-guest-layout>

  <x-slot name="js_files">
      <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('js/components/show-password.js?v='.time()) }}"></script>
  </x-slot>

  <x-authentication-card>
    <x-slot name="logo">
      <div class="w-1/6 mx-auto">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
      </div>
    </x-slot>

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div>
        <x-label for="name" value="{{ __('Name') }}" />
        <div class="relative">
          <i class="bi bi-person-circle absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        </div>
      </div>
      <div class="mt-4">
        <x-label for="email" value="{{ __('Email') }}" />
        <div class="relative">
          <i class="bi bi-envelope-open absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <x-input id="email" class="focus-and-blur pl-9 lock mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>
      </div>

      <div class="mt-4">
        <x-label for="password" value="{{ __('Password') }}" />
        <div class="relative">
          <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <x-input id="password" class="focus-and-blur pl-9 block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        </div>
      </div>
      <a href="#" class="show_password outline-none flex justify-end text-xs pt-1 text-gray-600 dark:text-gray-400" data-state="hide" data-target="password">{{ __('word.general.show_password') }}</a>

      <div>
        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
        <div class="relative">
          <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <x-input id="password_confirmation" class="focus-and-blur pl-9 block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>
      </div>

      <a href="#" class="show_password outline-none flex justify-end text-xs pt-1 pb-4 text-gray-600 dark:text-gray-400" data-state="hide" data-target="password_confirmation">{{ __('word.general.show_password') }}</a>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
      <div class="mt-4">
        <x-label for="terms">
          <div class="flex items-center">
            <x-checkbox name="terms" id="terms" required />

            <div class="ms-2">
              {!! __('I agree to the :terms_of_service and :privacy_policy', [
              'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
              'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
              ]) !!}
            </div>
          </div>
        </x-label>
      </div>
      @endif

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-button class="ms-4">
          {{ __('Register') }}
        </x-button>
      </div>
    </form>
  </x-authentication-card>
</x-guest-layout>
