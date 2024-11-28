<x-app-layout>
  <x-slot name="title">
    {{ __('word.currency.meta.index.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.currency.meta.index.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.currency.meta.index.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.currency.meta.index.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.currency.meta.index.description')}}
  </x-slot>

  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
    <script src="{{ asset('/js/currency/index.js?v='.time()) }}"></script>
  </x-slot>


  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.currency.resource.index') }}
    </h2>
  </x-slot>

  @if (session('success'))
  <x-alert :message="session('success')" />
  @endif

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden shadow-xl sm:rounded-lg">
        <div class="container mx-auto p-4">
          <div class="flex justify-between mb-4">
            <a href="{{ route('currencies.create') }}" class="bg-green-500 text-white px-6 py-3 rounded">
              <i class="bi bi-plus"></i>
            </a>
            <form method="GET" action="{{ route('currencies.index') }}" onchange="this.submit()" class="inline-block">
              <select name="perPage" class="border border-gray-300 rounded pr-8 w-36">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>{{ __('word.general.10_items') }}</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
              </select>
            </form>

          </div>

          <!-- Tabla de datos -->
          <table class="min-w-full border border-collapse border-[#2563eb] text-white text-center">
            <thead>
              <tr class="bg-[#2563eb] text-white">
                <th class="border border-[#2563eb] p-3">#</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Nombre')">{{ __('word.currency.attribute.name') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Fecha de registro')">{{ __('word.currency.attribute.created_at') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Estado')">{{ __('word.currency.attribute.status') }}</th>
                <th class="border border-[#2563eb] p-3">Acciones</th>
              </tr>
            </thead>
            <tbody>

              @foreach($currencies as $currency)
              <tr class="hover:bg-slate-700 transition duration-200">
                <th class="border border-[#2563eb] p-2">{{ $loop->iteration }}</th>
                <td class="border border-[#2563eb] p-2">{{ $currency->name }}</td>
                <td class="border border-[#2563eb] p-2">{{ $currency->created_at->diffForHumans() }}</td>
                <td class="border border-[#2563eb] p-2">{{ $currency->status ? '🟢' : '🔴' }}</td>
                <td class="border border-[#2563eb] p-2 flex justify-evenly">
                  <a href="{{ route('currencies.show', $currency->currency_uuid) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('currencies.edit',$currency->currency_uuid) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <div class="flex justify-evenly">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="openModal('{{$currency->currency_uuid}}', '{{$currency->name}}')">
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Modal -->
              <div id="modal-{{$currency->currency_uuid}}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                  <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                    <div class="modal-header p-4 border-b flex justify-between items-center">
                      <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                      <button type="button" class="close-modal text-gray-500 hover:text-gray-700" onclick="closeModal('{{$currency->currency_uuid}}')">&times;</button>
                    </div>
                    <div class="modal-body p-6">
                      <p class="text-gray-600">{{__('word.currency.delete_confirmation')}} <strong id="name-{{$currency->currency_uuid}}"></strong>{{__('word.general.delete_warning')}}</p>
                    </div>
                    <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                      <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400" onclick="closeModal('{{$currency->currency_uuid}}')">{{ __('Close') }}</button>
                      <form id="delete-form-{{$currency->currency_uuid}}" action="{{route('currencies.destroy',$currency->currency_uuid)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-red-600">{{ __('Delete') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              @endforeach
            </tbody>
          </table>
          <div class="pagination-wrapper mt-4">
            {!! $currencies->appends(['perPage' => $perPage])->links() !!}
          </div>
        </div>

      </div>
    </div>
  </div>


</x-app-layout>