<x-app-layout>
  <x-slot name="title">
    {{ __('word.incomefromtransfer.meta.edit.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.incomefromtransfer.meta.edit.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.incomefromtransfer.meta.edit.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.incomefromtransfer.meta.edit.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.incomefromtransfer.meta.edit.description')}}
  </x-slot>

  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/incomefromtransfer/form.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('js/ticketing.js?v='.time()) }}"></script>
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.incomefromtransfer.resource.edit') }}
    </h2>
  </x-slot>
  <div class="py-12">
    <div class=" mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-1/2 mx-auto p-8">
        <form method="POST" action="{{route('incomefromtransfers.update', $incomefromtransfer->incomefromtransfer_uuid)}}">
          @csrf
          @method("PUT" )
          <div class="flex flex-row justify-between items-start space-x-4">
            <div class="w-1/2">
              <x-form-incomefromtransfer :incomefromtransfer="$incomefromtransfer" />
              
              <div class="mt-4">
                <x-label for="service_uuid" value="{{ __('word.incomefromtransfer.attribute.service_uuid') }} *" />
                <div class="relative">
                  <i id="service_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
                  <select id="service_uuid" class="pl-9 pr-3 py-2 bg-[#111827] text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-[#2563eb] focus:border-[#2563eb] w-full" name="service_uuid">
                    <option value="" disabled {{ old('service_uuid', $incomefromtransfer->service_uuid) ? '' : 'selected' }}>
                      {{__('word.incomefromtransfer.select_service')}}
                    </option>
                    @foreach($services as $item)
                    <option value="{{ $item->service_uuid }}" {{ (old('service_uuid', $incomefromtransfer->service_uuid) == $item->service_uuid) ? 'selected' : '' }}> {{$item->name}}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="mt-4">
                <x-label for="status" value="{{ __('word.incomefromtransfer.attribute.status') }}" />
                <div class="relative flex items-center">
                  <span id="toggleStatus" class="mr-2 text-gray-700 {{ $incomefromtransfer->status ? 'text-green-500' : 'text-red-500' }}">
                    {{ $incomefromtransfer->status ? 'On' : 'Off' }}
                  </span>
                  <button type="button" id="toggleButton"
                    class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $incomefromtransfer->status ? 'bg-green-500' : 'bg-red-500' }}"
                    onclick="toggleStatus()">
                    <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $incomefromtransfer->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                  </button>
                  <input type="hidden" name="status" id="status" value="{{ $incomefromtransfer->status ? '1' : '0' }}">
                </div>
              </div>

              @if ($errors->any())
              <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <strong class="font-bold">¡Ups! Algo salió mal:</strong>
                <ul class="mt-2 ml-4 list-disc list-inside">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
            </div>
            <div class="w-1/2">
              <x-form-billcoin :denomination="$denomination" ></x-form-billcoin>
              <div class="mt-4 flex justify-end">
                <x-button>
                  {{ __('Save') }}
                </x-button>
              </div>
            </div>
            <form />
          </div>
      </div>
    </div>
  </div>
</x-app-layout>