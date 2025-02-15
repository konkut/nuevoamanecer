<x-action-section>
    <x-slot name="title">
        {{ __('Two Factor Authentication') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Add additional security to your account using two factor authentication.') }}
    </x-slot>
    <x-slot name="content">
        <form method="POST" action="{{ route('status_two_factor') }}" onsubmit="fetch_change_two_factor(this, '{{url('/')}}',  event)" class="space-y-4">
            @csrf
            <div class="grid grid-cols-6 gap-6 px-4 sm:px-6 sm:pt-6">
                <div class="col-span-6 sm:col-span-5">
                    <h3 id="title-status" class="text-lg font-medium text-gray-900">
                        @if ($this->user->status_two_factor)
                            {{ __('word.two_factor.title_enable') }}
                        @else
                            {{ __('word.two_factor.title_disable') }}
                        @endif
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ __('word.two_factor.description') }}
                    </p>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="current_password" value="{{__('Confirm Password')}}"/>
                    <div class="relative mt-4">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="password_two_factor"
                                 class="focus-and-blur focus-and-blur pl-9 block mt-1 w-full"
                                 type="password" name="password_two_factor" required
                                 inputmode="text" autocomplete="current-password"
                                 value="{{ old('password_two_factor') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end pt-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="password_two_factor">{{ __('word.general.show_password') }}</a>
                </div>
            </div>
            <div
                class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-button type="submit" id="button-status">
                    @if ($this->user->status_two_factor)
                        {{ __('word.two_factor.button_disable') }}
                    @else
                        {{ __('word.two_factor.button_enable') }}
                    @endif
                </x-button>
            </div>
        </form>
    </x-slot>
</x-action-section>
