<x-action-section>
    <x-slot name="title">
        {{ __('Browser Sessions') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Manage and log out your active sessions on other browsers and devices.') }}
    </x-slot>
    <x-slot name="content">
        <form action="{{ route('logout_session')}}" method="POST" onsubmit="fetch_logout_session(this, event)">
            @csrf
            <div class="grid grid-cols-6 gap-6 px-4 sm:px-6 sm:pt-6">
                <div class="col-span-6 sm:col-span-5">
                    <h3 id="title-status"
                        class="text-lg font-medium text-gray-900">{{ __('word.logout_session.title') }}</h3>
                    @if (count($this->sessions) > 0)
                        <div class="mt-5 space-y-6">
                            @foreach ($this->sessions as $session)
                                <div class="flex items-center" data-state="{{$session->is_current_device}}">
                                    <div>
                                        @if ($session->agent->isDesktop())
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }}
                                            - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">
                                                {{ $session->ip_address }},
                                                @if ($session->is_current_device)
                                                    <span
                                                        class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                                @else
                                                    {{ __('Last active') }} {{ $session->last_active }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <p class="mt-6 text-sm text-gray-600">{{ __('word.logout_session.subtitle') }}</p>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="password_logout" value="{{__('Confirm Password')}}"/>
                    <div class="relative mt-4">
                        <i class="bi bi-fingerprint absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input id="password_logout"
                                 class="focus-and-blur focus-and-blur pl-9 block mt-1 w-full"
                                 type="password" name="password_logout" required
                                 inputmode="text" autocomplete="current-password"
                                 value="{{ old('password_logout') }}"/>
                        <x-box-password></x-box-password>
                    </div>
                    <a href="javascript:void(0)"
                       class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
                       onclick="change_state_password(this)"
                       data-state="hide" data-target="password_logout">{{ __('word.general.show_password') }}</a>
                </div>
            </div>
            <div
                class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                <x-button>
                    {{ __('Log Out Other Browser Sessions') }}
                </x-button>
            </div>
        </form>
    </x-slot>
</x-action-section>
