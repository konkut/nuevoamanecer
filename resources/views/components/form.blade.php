<form method="POST" action="{{ route('income.store') }}">
  @csrf

  <div>
    <x-label for="codigo" value="{{ __('Code') }}" />
    <x-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="old('codigo')" required autofocus />

  </div>
  <div class="mt-4">
    <x-label for="total" value="{{ __('Total') }}" />
    <x-input id="total" class="block mt-1 w-full" type="text" name="total" :value="old('total')" required />

  </div>
  <x-button class="mt-4 flex ">
    {{ __('Save') }}
  </x-button>
  <form />