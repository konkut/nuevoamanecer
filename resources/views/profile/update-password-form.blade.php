<x-action-section>
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>
    <x-slot name="content">
        <form action="{{ route('update_password')}}" method="POST" onsubmit="fetch_update_password(this, event)" >
            @csrf
            @method("PUT" )
            <div class="grid grid-cols-6 gap-6 px-4 sm:px-6 sm:pt-6">
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="current_password" value="{{ __('Current Password') }}"/>
                    <div class="relative z-10">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input
                            id="current_password"
                            class="focus-and-blur pl-9 block mt-1 w-full"
                            type="password" required
                            name="current_password" autocomplete="current-password"
                            value="{{ old('current_password') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end pt-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="current_password">{{ __('word.general.show_password') }}</a>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="password" value="{{ __('New Password') }}"/>
                    <div class="relative z-10">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input
                            id="password"
                            class="focus-and-blur pl-9 block mt-1 w-full"
                            type="password" required
                            name="password" autocomplete="new-password"
                            value="{{ old('password') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end pt-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="password">{{ __('word.general.show_password') }}</a>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                    <div class="relative z-10">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input
                            id="password_confirmation"
                            class="focus-and-blur pl-9 block mt-1 w-full"
                            type="password" required
                            name="password_confirmation"
                            name="password_confirmation" autocomplete="new-password"
                            value="{{ old('password_confirmation') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="password_confirmation">{{ __('word.general.show_password') }}</a>
                </div>
            </div>
            <div
                class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-button>
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>
    </x-slot>
</x-action-section>
