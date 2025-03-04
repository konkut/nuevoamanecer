<x-app-layout>
  <x-slot name="title">
    {{ __('word.currency.meta.create.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.currency.meta.create.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.currency.meta.create.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.currency.meta.create.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.currency.meta.create.description')}}
  </x-slot>


  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/currency/form.js?v='.time()) }}"></script>
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.currency.resource.create') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-1/3 mx-auto p-8">
        <form method="POST" action="{{route('currencies.store')}}">
          @csrf
          <x-form-currency></x-form-currency>
          <x-button class="mt-4 flex ">
            {{ __('Save') }}
          </x-button>
          <form />
      </div>
    </div>
  </div>
</x-app-layout>
