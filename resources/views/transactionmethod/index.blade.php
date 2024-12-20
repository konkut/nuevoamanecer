<x-app-layout>
    <x-slot name="title">
        {{ __('word.transactionmethod.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.transactionmethod.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.transactionmethod.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.transactionmethod.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.transactionmethod.meta.index.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script src="{{ asset('js/transactionmethod/index.js?v='.time()) }}"></script>
    </x-slot>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.transactionmethod.resource.index') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end space-x-2 items-center mb-4">
                        @can('transactionmethods.create')
                            <a href="{{ route('transactionmethods.create') }}"
                               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                               title="Agregar">
                                <i class="bi bi-plus"></i>
                            </a>
                        @endcan
                        <form method="GET" action="{{ route('transactionmethods.index') }}" onchange="this.submit()"
                              class="inline-block">
                            <select name="perPage" class="border border-gray-300 rounded text-sm pr-8 w-36">
                                <option
                                    value="10" {{ $perPage == 10 ? 'selected' : '' }}>{{ __('word.general.10_items') }}</option>
                                <option
                                    value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                                <option
                                    value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
                            </select>
                        </form>
                    </div>

                    <!-- Tabla de datos -->
                    <div class="overflow-x-auto text-black">
                        <table class="min-w-full border-collapse border-[#2563eb] text-center text-sm">
                            <thead>
                            <tr class="bg-[#d1d5db]" title="Buscar">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'nombre')">{{ __('word.service.attribute.name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'fecha de registro')">{{ __('word.service.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'estado')">{{ __('word.service.attribute.status') }}</th>
                                @can('transactionmethods.create')
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1" title="">{{ __('word.general.actions') }}</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactionmethods as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->diffForHumans() }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                    @can('transactionmethods.create')
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                @can('transactionmethods.index')
                                                    <a href="javascript:void(0);"
                                                       title="Visualizar"
                                                       class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                                       onclick="openDetailsModal('{{$item->transactionmethod_uuid}}')">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('transactionmethods.edit')
                                                    <a href="{{ route('transactionmethods.edit',$item->transactionmethod_uuid) }}"
                                                       class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                                       title="Modificar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan
                                                @can('transactionmethods.destroy')
                                                    <button type="button"
                                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openModal('{{ $item->transactionmethod_uuid }}', '{{ $item->name }}')"
                                                            title="Eliminar">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                                <!-- modal show -->
                                <div id="details-modal-{{$item->transactionmethod_uuid}}"
                                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto py-3">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div
                                            class="bg-white rounded-2xl shadow-2xl w-11/12 sm:w-3/4 md:w-1/3 transform transition-transform scale-100 opacity-100 duration-300">
                                            <div
                                                class="modal-header p-4 bg-[#d1d5db] text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                                <button type="button"
                                                        class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                                                        onclick="closeDetailsModal('{{$item->transactionmethod_uuid}}')">
                                                    &times;
                                                </button>
                                                <h1 class="text-lg font-semibold mx-auto">{{ __('word.transactionmethod.resource.show') }}</h1>
                                            </div>
                                            <div
                                                class="py-12 px-4 text-slate-600 rounded-b-2xl shadow-inner md:max-w-2xl p-8">
                                                <div class="text-center">
                                                    <div>
                                                        <p class="text-sm font-semibold ">{{ __('word.transactionmethod.attribute.name') }}</p>
                                                        <p>{{ $item->name }}</p>
                                                    </div>
                                                    @if($item->description)
                                                        <div class="mt-6">
                                                            <p class="text-sm font-semibold ">{{ __('word.transactionmethod.attribute.description') }}</p>
                                                            <p>{{ $item->description }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold ">{{ __('word.transactionmethod.attribute.status') }}</p>
                                                        <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                    </div>

                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold">{{ __('word.transactionmethod.attribute.created_at') }}</p>
                                                        <p> {{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold ">{{ __('word.transactionmethod.attribute.updated_at') }}</p>
                                                        <p> {{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div id="modal-{{$item->transactionmethod_uuid}}"
                                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700"
                                                        onclick="closeModal('{{$item->transactionmethod_uuid}}')">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.transactionmethod.delete_confirmation')}}
                                                    <strong
                                                        id="name-{{$item->transactionmethod_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeModal('{{$item->transactionmethod_uuid}}')">{{ __('Close') }}</button>
                                                <form id="delete-form-{{$item->transactionmethod_uuid}}"
                                                      action="{{route('transactionmethods.destroy',$item->transactionmethod_uuid)}}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-red-600">{{ __('Delete') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginaci車n -->
                    <div class="pagination-wrapper mt-4">
                        {!! $transactionmethods->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
