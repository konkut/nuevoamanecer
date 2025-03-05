<x-app-layout>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ url('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/password/show-password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/password/message_password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/password/random_password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/setting/fetch_change_two_factor.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/setting/fetch_update_password.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/setting/fetch_update_user.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/setting/fetch_logout_session.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ url('/js/setting/fetch_disable_account.js?v='.time()) }}"></script>
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl leading-tight">
      {{ __('Profile') }}
    </h2>
  </x-slot>
  <div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      @if (Laravel\Fortify\Features::canUpdateProfileInformation())
      @livewire('profile.update-profile-information-form')
      <x-section-border />
      @endif

      @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
      <div class="mt-10 sm:mt-0">
        @livewire('profile.update-password-form')
      </div>
      <x-section-border />
      @endif

      @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
      <div class="mt-10 sm:mt-0">
        @livewire('profile.two-factor-authentication-form')
      </div>
      <x-section-border />
      @endif
      <div class="mt-10 sm:mt-0">
        @livewire('profile.logout-other-browser-sessions-form')
      </div>

      @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
      <x-section-border />

      <div class="mt-10 sm:mt-0">
        @livewire('profile.delete-user-form')
      </div>
      @endif
    </div>
  </div>
</x-app-layout>
