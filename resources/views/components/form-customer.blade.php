<div>
  <x-label for="name" value="{{ __('word.customer.attribute.name') }} *" />
  <div class="relative">
    <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
    <x-input required id="name" class="first-element focus-and-blur pl-9 block mt-1 w-full"
             inputmode="text" autocomplete="one-time-code" type="text" name="name" value="{{ old('name', $customer->name?? '') }}" />
  </div>
  @error('name')
  <small class="font-bold text-red-500/80">{{ $message }}</small>
  @enderror
</div>
<div class="mt-4">
    <x-label for="email" value="{{ __('word.customer.attribute.email') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="email" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="email" autocomplete="one-time-code" type="email" name="email" value="{{ old('email', $customer->email?? '') }}" />
    </div>
    @error('email')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="phone" value="{{ __('word.customer.attribute.phone') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="phone" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="numeric" autocomplete="one-time-code" type="text" name="phone" value="{{ old('phone', $customer->phone?? '') }}" />
    </div>
    @error('phone')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>
<div class="mt-4">
    <x-label for="address" value="{{ __('word.customer.attribute.address') }} *" />
    <div class="relative">
        <i class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input required id="address" class="first-element focus-and-blur pl-9 block mt-1 w-full"
                 inputmode="text" autocomplete="one-time-code" type="text" name="address" value="{{ old('address', $customer->address?? '') }}" />
    </div>
    @error('address')
    <small class="font-bold text-red-500/80">{{ $message }}</small>
    @enderror
</div>

