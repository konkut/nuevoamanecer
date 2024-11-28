<x-app-layout>
  <x-slot name="title">
    {{ __('word.incomefromtransfer.meta.create.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.incomefromtransfer.meta.create.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.incomefromtransfer.meta.create.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.incomefromtransfer.meta.create.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.incomefromtransfer.meta.create.description')}}
  </x-slot>


  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('js/ticketing.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/incomefromtransfer/form.js?v='.time()) }}"></script>
  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.incomefromtransfer.resource.create') }}
    </h2>
  </x-slot>


  <div class="py-12">
    <div class=" mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg w-[1000px] mx-auto p-8">
        <form method="POST" action="{{ route('incomefromtransfers.store') }}">
          @csrf
          <div class="flex flex-row justify-between items-start space-x-4">
            <div class="w-1/2">
              <x-form-incomefromtransfer :incomefromtransfer="$incomefromtransfer" :services="$services" />
              
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

            <!-- Contenedor del formulario de billetes y monedas -->
            <div class="w-1/2">
              <x-form-billcoin :denomination="$denomination"></x-form-billcoin>
              <div class="mt-4 flex justify-end">
                <x-button>
                  {{ __('Save') }}
                </x-button>
              </div>
            </div>
          </div>

          <!-- Botón de guardado debajo de los formularios -->

        </form>
      </div>
    </div>
  </div>
</x-app-layout>