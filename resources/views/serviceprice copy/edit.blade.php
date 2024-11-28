<x-app-layout>
  <x-slot name="title">
    {{ __('word.service.meta.edit.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.service.meta.edit.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.service.meta.edit.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.service.meta.edit.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.service.meta.edit.description')}}
  </x-slot>

  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/service/form.js?v='.time()) }}"></script>
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.service.resource.edit') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-1/3 mx-auto p-8">
        <form method="POST" action="{{route('servicesprices.update', $serviceprice->serviceprice_uuid)}}">
          @csrf
          @method("PUT" )

          <x-form-serviceprice :serviceprice="$serviceprice" :categories="$categories" />

          {{--
          <div class="mt-4">
            <x-label for="currency_uuid" value="{{ __('word.service.attribute.currency_uuid') }} *" />
            <div class="relative">
              <i id="currency_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
              <select id="currency_uuid" class="pl-9 pr-3 py-2 bg-[#111827] text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-[#2563eb] focus:border-[#2563eb] w-full" name="currency_uuid">
                <option value="" disabled {{ old('currency_uuid', $serviceprice->currency_uuid) ? '' : 'selected' }}>
                  {{__('word.service.select_currency')}}
                </option>
                @foreach($currencies as $item)
                <option value="{{ $item->currency_uuid }}" {{ (old('currency_uuid', $serviceprice->currency_uuid) == $item->currency_uuid) ? 'selected' : '' }}>
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
                <option value="" disabled {{ old('category_uuid', $serviceprice->category_uuid) ? '' : 'selected' }}>
                  {{__('word.service.select_category')}}
                </option>
                @foreach($categories as $item)
                <option value="{{ $item->category_uuid }}" {{ (old('category_uuid', $serviceprice->category_uuid) == $item->category_uuid) ? 'selected' : '' }}>
                  {{$item->name}}
                </option>
                @endforeach
              </select>
            </div>
            @error('category_uuid')
            <small class="font-bold text-red-500/80">{{ $message }}</small>
            @enderror
          </div>


          <div class="mt-4">
            <x-label for="status" value="{{ __('word.service.attribute.status') }}" />
            <div class="relative flex items-center">
              <span id="toggleStatus" class="mr-2 text-gray-700 {{ $serviceprice->status ? 'text-green-500' : 'text-red-500' }}">
                {{ $serviceprice->status ? 'On' : 'Off' }}
              </span>
              <button type="button" id="toggleButton"
                class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $serviceprice->status ? 'bg-green-500' : 'bg-red-500' }}"
                onclick="toggleStatus()">
                <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $serviceprice->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
              </button>
              <input type="hidden" name="status" id="status" value="{{ $serviceprice->status ? '1' : '0' }}">
            </div>
          </div>
          <x-button class="mt-4 flex ">
            {{ __('Save') }}
          </x-button>
          <form />
      </div>
    </div>
  </div>
</x-app-layout>