<x-app-layout>
  <x-slot name="title">
    {{ __('word.category.meta.index.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.category.meta.index.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.category.meta.index.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.category.meta.index.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.category.meta.index.description')}}
  </x-slot>

  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
    <script src="{{ asset('js/category/index.js?v='.time()) }}"></script>
  </x-slot>


  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.category.resource.index') }}
    </h2>
  </x-slot>

  @if (session('success'))
  <x-alert :message="session('success')" />
  @endif

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden shadow-xl sm:rounded-lg">
        <div class="container mx-auto p-4">
          <div class="clearfix mb-16">
            @can('categories.create')
            <a href="{{ route('categories.create') }}" class="float-left bg-green-500 text-white px-6 py-3 rounded">
              <i class="bi bi-plus"></i>
            </a>
            @endcan

            <form method="GET" action="{{ route('categories.index') }}" onchange="this.submit()" class="float-right">
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
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Nombre')">{{ __('word.category.attribute.name') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Fecha de registro')">{{ __('word.category.attribute.created_at') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Estado')">{{ __('word.category.attribute.status') }}</th>
                @can('categories.create')
                <th class="border border-[#2563eb] p-3">Acciones</th>
                @endcan
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $category)
              <tr class="hover:bg-slate-700 transition duration-200">
                <th class="border border-[#2563eb] p-2">{{ $loop->iteration }}</th>
                <td class="border border-[#2563eb] p-2">{{ $category->name }}</td>
                <td class="border border-[#2563eb] p-2">{{ $category->created_at->diffForHumans() }}</td>
                <td class="border border-[#2563eb] p-2">{{ $category->status ? '🟢' : '🔴' }}</td>
                @can('categories.create')
                <td class="border border-[#2563eb] p-2 flex justify-evenly">
                  <a href="{{ route('categories.show', $category->category_uuid) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('categories.edit',$category->category_uuid) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <div class="flex justify-evenly">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="openModal('{{$category->category_uuid}}', '{{$category->name}}')">
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </div>
                </td>
                @endcan
              </tr>
              <!-- Modal -->
              <div id="modal-{{$category->category_uuid}}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                  <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                    <div class="modal-header p-4 border-b flex justify-between items-center">
                      <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                      <button type="button" class="close-modal text-gray-500 hover:text-gray-700" onclick="closeModal('{{$category->category_uuid}}')">&times;</button>
                    </div>
                    <div class="modal-body p-6">
                      <p class="text-gray-600">{{__('word.category.delete_confirmation')}} <strong id="name-{{$category->category_uuid}}"></strong>{{__('word.general.delete_warning')}}</p>
                    </div>
                    <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                      <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400" onclick="closeModal('{{$category->category_uuid}}')">{{ __('Close') }}</button>
                      <form id="delete-form-{{$category->category_uuid}}" action="{{route('categories.destroy',$category->category_uuid)}}" method="POST">
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
            {!! $categories->appends(['perPage' => $perPage])->links() !!}
          </div>
        </div>

      </div>
    </div>
  </div>


</x-app-layout>