<div class="mt-4 relative">
    <x-label for="password" value="{{ __('word.force_password_change.attribute.password') }} *"/>
    <div class="relative">
        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="password"
                 class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 type="password" name="password" required
                 inputmode="text" autocomplete="new-password"
                 value="{{ old('password') }}"/>
        <x-box-password></x-box-password>
    </div>
</div>
<a href="javascript:void(0)"
   class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
   onclick="change_state_password(this)"
   data-state="hide" data-target="password">{{ __('word.general.show_password') }}</a>

<div class="mt-4 relative">
    <x-label for="password_confirmation" value="{{ __('word.force_password_change.attribute.password_confirmation') }} *"/>
    <div class="relative">
        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="password_confirmation"
                 class="focus-and-blur pl-9 block mt-1 w-full"
                 type="password" name="password_confirmation" required
                 inputmode="text" autocomplete="new-password"
                 value="{{ old('password_confirmation') }}"/>
        <x-box-password></x-box-password>
    </div>
</div>
<a href="javascript:void(0)"
   class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
   onclick="change_state_password(this)"
   data-state="hide" data-target="password_confirmation">{{ __('word.general.show_password') }}</a>


