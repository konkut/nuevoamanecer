<x-action-section>
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>
    <x-slot name="content">
        <form action="{{ route('update_user')}}" method="POST" onsubmit="fetch_update_user(this, event)">
            @csrf
            @method("PUT" )
            <div class="grid grid-cols-6 gap-6 px-4 sm:px-6 sm:pt-6">
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <div class="relative z-10">
                        <i class="bi bi-person-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input
                            id="name"
                            class="first-element focus-and-blur pl-9 block mt-1 w-full"
                            type="text"
                            name="name" autocomplete="name"
                            value="{{ old('name', auth()->user()->name) }}"></x-input>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-5">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <div class="relative z-10">
                        <i class="bi bi-envelope absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                        <x-input
                            id="email"
                            class="focus-and-blur pl-9 block mt-1 w-full"
                            type="text"
                            name="email" autocomplete="email"
                            value="{{ old('email', auth()->user()->email) }}"></x-input>
                    </div>
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
