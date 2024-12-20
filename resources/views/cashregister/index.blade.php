<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashregister.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashregister.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashregister.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashregister.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashregister.meta.index.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/fetch_modal_show.js?v='.time()) }}"></script>
    </x-slot>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.cashregister.resource.index') }}
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
                        <a href="{{ route('cashregisters.create') }}"
                           class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                           title="Agregar">
                            <i class="bi bi-plus"></i>
                        </a>
                        <form method="GET" action="{{ route('cashregisters.index') }}" onchange="this.submit()"
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
                    <div class="overflow-x-auto text-black">
                        <table class="min-w-full border-collapse border-[#2563eb] text-center text-sm">
                            <thead>
                            <tr class="bg-[#d1d5db]" title="Buscar">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'nombre')">{{ __('word.cashregister.attribute.name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'monto inicial')">{{ __('word.cashregister.attribute.initial_balance') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'estado')">{{ __('word.cashregister.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'registrado por')">{{ __('word.cashregister.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1" title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashregisters as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->initial_balance, 2) }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        <div class="flex justify-center space-x-1">
                                            <form id="details-form-{{$item->cashregister_uuid}}"
                                                  title="Visualizar"
                                                  action="{{ route('cashregisters.showdetail', $item->cashregister_uuid) }}"
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="button"
                                                        onclick="fetchDetails('{{$item->cashregister_uuid}}')"
                                                        class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('cashregisters.edit',$item->cashregister_uuid) }}"
                                               class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                               title="Modificar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                    onclick="openModal('{{ $item->cashregister_uuid }}', '{{$item->name }}')"
                                                    title="Eliminar">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                                <div id="details-modal-{{$item->cashregister_uuid}}"
                                     class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-11/12 max-w-5xl mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                            <div
                                                class="modal-header p-4 bg-gray-100 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                <h1 class="text-lg font-semibold mx-auto">{{__('word.cashregister.resource.show')}}</h1>
                                                <button type="button"
                                                        class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                        onclick="closeDetailsModal('{{$item->cashregister_uuid}}')">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body py-6 px-4 sm:px-6 text-gray-700 overflow-hidden">
                                                <div class="grid grid-cols-1 md:grid-cols-2">
                                                    <div class="text-center pb-8 md:pb-0">
                                                        <div>
                                                            <p class="text-sm font-semibold">{{ __('word.cashregister.attribute.name') }}</p>
                                                            <p>{{ $item->name }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.cashregister.attribute.initial_balance') }}</p>
                                                            <p>{{ $item->initial_balance }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold ">{{ __('word.cashregister.attribute.status') }}</p>
                                                            <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.cashregister.attribute.created_at') }}</p>
                                                            <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.cashregister.attribute.updated_at') }}</p>
                                                            <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.cashregister.attribute.user_id') }}</p>
                                                            <p>{{ $item->user->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-center pb-8 md:pb-0"
                                                         id="modal-show-{{$item->cashregister_uuid}}">
                                                        <div class="bg-[#f3f4f6] p-2">
                                                            <div class="font-bold py-1 text-sm text-center">MONTO DE APERTURA
                                                            </div>
                                                        </div>
                                                        <div class="divide-y divide-[#f3f4f6]">
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">200</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-bill-200-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">100</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-bill-100-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">50</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-bill-50-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">20</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-bill-20-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">10</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-bill-10-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">5</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-5-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">2</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-2-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">1</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-1-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">0.5</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-0-5-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">0.2</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-0-2-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">0.1</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-coin-0-1-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                            <div
                                                                class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                <div class="w-1/3 text-start">Total</div>
                                                                <div class="w-1/2 text-start"
                                                                     id="physical-balance-total-{{$item->cashregister_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div id="modal-{{$item->cashregister_uuid}}"
                                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700"
                                                        onclick="closeModal('{{$item->cashregister_uuid}}')">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.cashregister.delete_confirmation')}}
                                                    <strong
                                                        id="name-{{$item->cashregister_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeModal('{{$item->cashregister_uuid}}')">{{ __('Close') }}</button>
                                                <form
                                                    action="{{route('cashregisters.destroy',$item->cashregister_uuid)}}"
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
                        {!! $cashregisters->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
