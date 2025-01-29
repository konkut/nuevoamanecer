<div class="mt-6">
    <x-label for="name" value="{{ __('word.user.attribute.name') }} *"/>
    <div class="relative">
        <i class="bi bi-person-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full" type="text" name="name"
                 inputmode="text" autocomplete="name" autofocus value="{{ old('name', $user->name?? '') }}"/>
    </div>
    @error('name')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>

<div class="mt-6">
    <x-label for="email" value="{{ __('word.user.attribute.email') }} *"/>
    <div class="relative">
        <i class="bi bi-envelope absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="email" class="focus-and-blur pl-9 block mt-1 w-full" type="text" name="email"
                 inputmode="email" autocomplete="username" value="{{ old('email', $user->email?? '') }}"/>
    </div>
    @error('email')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-6">
    <x-label for="password" value="{{ __('word.user.attribute.password') }}{{ $page === 'create' ? ' *' : ' (opcional)' }}"/>
    <div class="relative">
        <i class="bi bi-person-fill-lock absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input
            id="password"
            class="focus-and-blur pl-9 block mt-1 w-full"
            inputmode="text" autocomplete="new-password"
            type="password"
            name="password"
            value="{{ old('password') }}"/>
        <x-box-password></x-box-password>
    </div>
    @error('password')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
    <a href="javascript:void(0)"
       class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
       onclick="change_state_password(this)"
       data-state="hide" data-target="password">{{ __('word.general.show_password') }}</a>
</div>

<div class="mt-6">
    <x-label for="password_confirmation" value="{{ __('word.user.attribute.password_confirmation') }}{{ $page === 'create' ? ' *' : ' (opcional)' }}"/>
    <div class="relative">
        <i class="bi bi-person-fill-lock absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input
            id="password_confirmation"
            class="focus-and-blur pl-9 block mt-1 w-full"
            inputmode="text" autocomplete="new-password"
            type="password"
            name="password_confirmation"
            value="{{ old('password_confirmation') }}"/>
        <x-box-password></x-box-password>
    </div>
    @error('password_confirmation')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
    <a href="javascript:void(0)"
       class="show_password outline-none flex justify-end py-4 text-xs text-gray-600"
       onclick="change_state_password(this)"
       data-state="hide" data-target="password_confirmation">{{ __('word.general.show_password') }}</a>
</div>
<div class="my-4">
    <x-label for="roles" value="{{ __('word.user.attribute.roles') }}" />
    <div class="flex flex-row flex-wrap justify-evenly mt-2">
        @foreach($roles as $role)
            <div class="flex items-center">
                <input type="checkbox" name="roles[]"
                       value="{{ $role->id }}"
                       id="role_{{ $role->id }}"
                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded mr-2"
                    {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                <label for="role_{{ $role->id }}" class="text-gray-700">{{ $role->name }}</label>
            </div>
        @endforeach
    </div>
    @error('roles')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>

