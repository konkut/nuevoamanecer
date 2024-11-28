<div>
  <x-label for="name" value="{{ __('word.user.attribute.name') }} *" />
  <div class="relative">
    <i id="name_icon" class="bi bi-person absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="name" class="pl-9 block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>

<div class="mt-4">
  <x-label for="email" value="{{ __('word.user.attribute.email') }} *" />
  <div class="relative">
    <i id="email_icon" class="bi bi-envelope absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="email" class="pl-9 block mt-1 w-full" type="text" name="email" value="{{ old('email', $user->email?? '') }}" />
  </div>
  @error('email')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>

<div class="mt-4">
  <x-label for="password" value="{{ __('word.user.attribute.password') }}" />
  <div class="relative">
    <i id="password_icon" class="bi bi-lock absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input
      id="password"
      class="pl-9 block mt-1 w-full"
      type="password"
      name="password" />
  </div>
  @error('password')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>