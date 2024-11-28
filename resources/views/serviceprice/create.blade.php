<x-app-layout>
  <x-slot name="title">
    {{ __('word.service.meta.create.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.service.meta.create.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.service.meta.create.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.service.meta.create.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.service.meta.create.description')}}
  </x-slot>


  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/service/form.js?v='.time()) }}"></script>
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.service.resource.create') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-1/3 mx-auto p-8">
        <form method="POST" action="{{route('servicesprices.store')}}">
          @csrf

          <x-form-serviceprice :categories="$categories"></x-form-serviceprice>

          {{--
          <div class="mt-4">
            <x-label for="currency_uuid" value="{{ __('word.service.attribute.currency_uuid') }} *" />
          <div class="relative">
            <i id="currency_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
            <select id="currency_uuid" class="pl-9 pr-3 py-2 bg-[#111827] text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-[#2563eb] focus:border-[#2563eb] w-full" name="currency_uuid">
              <option value="" disabled {{ old('currency_uuid') ? '' : 'selected' }}>
                {{__('word.service.select_currency')}}
              </option>
              @foreach($currencies as $item)
              <option value="{{ $item->currency_uuid }}" {{ old('currency_uuid') == $item->currency_uuid ? 'selected' : '' }}>
                {{$item->name}}
              </option>
              @endforeach
            </select>
          </div>
          @error('currency_uuid')
          <small class="font-bold text-red-500">{{ $message }}</small>
          @enderror
      </div>
      --}}

      <div class="mt-4">
        <x-label for="category_uuid" value="{{ __('word.service.attribute.category_uuid') }} *" />
        <div class="relative">
          <i id="category_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
          <select id="category_uuid" class="pl-9 pr-3 py-2 bg-[#111827] text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-[#2563eb] focus:border-[#2563eb] w-full" name="category_uuid">
            <option value="" disabled {{ old('category_uuid') ? '' : 'selected' }}>
              {{__('word.service.select_category')}}
            </option>
            @foreach($categories as $item)
            <option value="{{ $item->category_uuid }}" {{ old('category_uuid') == $item->category_uuid ? 'selected' : '' }}>
              {{$item->name}}
            </option>
            @endforeach
          </select>
        </div>
        @error('category_uuid')
        <small class="font-bold text-red-500">{{ $message }}</small>
        @enderror
      </div>

      <x-button class="mt-4 flex ">
        {{ __('Save') }}
      </x-button>
      <form />
    </div>
  </div>
  </div>
</x-app-layout>