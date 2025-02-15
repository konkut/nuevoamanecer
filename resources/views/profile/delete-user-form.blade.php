<x-action-section>
    <x-slot name="title">
        {{ __('word.user.disable_title') }}
    </x-slot>
    <x-slot name="description">
        {{ __('word.user.disabled_text') }}
    </x-slot>
    <x-slot name="content">
        <form action="{{ route('disable_account')}}" method="POST" onsubmit="fetch_disable_account(this, '{{url('/')}}',  event)">
            @csrf
            <div class="grid grid-cols-6 gap-6 px-4 sm:px-6 sm:pt-6">
                <div class="col-span-6 sm:col-span-5">
                    <h3 id="title-status"
                        class="text-lg font-medium text-gray-900">{{ __('word.user.disable_title') }}</h3>
                    <p class="mt-6 text-sm text-gray-600">{{ __('word.user.disable_subtitle') }}</p>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="password_disable_account" value="{{__('Confirm Password')}}"/>
                    <div class="relative mt-4">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="password_disable_account"
                                 class="focus-and-blur focus-and-blur pl-9 block mt-1 w-full"
                                 type="password" name="password_disable_account" required
                                 inputmode="text" autocomplete="current-password"
                                 value="{{ old('password_disable_account') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="password_disable_account">{{ __('word.general.show_password') }}</a>
                </div>
            </div>
            <div
                class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-danger-button>
                    {{ __('word.user.disabled_button') }}
                </x-danger-button>
            </div>
        </form>
    </x-slot>
</x-action-section>
