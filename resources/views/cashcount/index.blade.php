<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashcount.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashcount.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashcount.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashcount.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashcount.meta.index.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/fetch_modal_show.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashcount/fetch_load.js?v='.time()) }}"></script>
    </x-slot>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.cashcount.resource.index') }}
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
                        @if($cashshiftsvalidated)
                            <a href="{{ route('cashcounts.create') }}"
                               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                               title="Agregar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </a>
                        @endif
                        <form method="GET" action="{{ route('cashcounts.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, 'saldo en físico')">{{ __('word.cashcount.attribute.physical_balance') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'saldo en el sistema')">{{ __('word.cashcount.attribute.system_balance') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'diferencia')">{{ __('word.cashcount.attribute.difference') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'cajero')">{{ __('word.cashcount.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'fecha de arqueo')">{{ __('word.cashcount.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'estado')">{{ __('word.cashcount.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashcounts as $item)
                                @if(auth()->user()->hasRole('Administrador') || $item->user_id == Auth::id())
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->physical_balance, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1"
                                            id="system-balance-table-{{$item->cashcount_uuid}}">{{ number_format($item->system_balance ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1"
                                            id="difference-table-{{$item->cashcount_uuid}}">{{ number_format($item->difference ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                @if(auth()->user()->hasRole('Administrador') || $item->status == "1")
                                                    <form id="load-form-{{$item->cashcount_uuid}}"
                                                          action="{{ route('cashcounts.load', $item->cashcount_uuid) }}"
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button"
                                                                onclick="fetchLoad('{{$item->cashcount_uuid}}')"
                                                                class="bg-pink-500 text-white px-2 py-1 rounded text-xs"
                                                                title="Actualizar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-arrow-clockwise"
                                                                 viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                      d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                                                <path
                                                                    d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form id="details-form-{{$item->cashcount_uuid}}"
                                                      action="{{ route('cashcounts.showdetail', $item->cashcount_uuid) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="button"
                                                            title="Visualizar"
                                                            onclick="fetchDetails('{{$item->cashcount_uuid}}')"
                                                            class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                            <path
                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @if(auth()->user()->hasRole('Administrador') || $item->status == "1")
                                                    <a href="{{ route('cashcounts.edit',$item->cashcount_uuid) }}"
                                                       class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                                       title="Modificar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-pencil"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                        </svg>
                                                    </a>
                                                    <button type="button"
                                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openModal('{{ $item->cashcount_uuid }}', '{{$item->date }}')"
                                                            title="Eliminar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-trash"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="details-modal-{{$item->cashcount_uuid}}"
                                         class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 max-w-5xl mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-gray-100 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                    <h1 class="text-lg font-semibold mx-auto">{{__('word.cashcount.resource.show')}}</h1>
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->cashcount_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body py-6 px-4 sm:px-6 text-gray-700 overflow-hidden">
                                                    <div
                                                        class="grid grid-cols-1 md:grid-cols-3">
                                                        <div class="text-center pb-8 md:pb-0">
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.physical_balance') }}</p>
                                                                <p>{{ $item->physical_balance }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.system_balance') }}</p>
                                                                <p id="system-balance-modal-{{$item->cashcount_uuid}}">{{ $item->system_balance ?? 0.00 }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.difference') }}</p>
                                                                <p id="difference-modal-{{$item->cashcount_uuid}}">{{ $item->difference }}</p>
                                                            </div>
                                                            @if($item->observation)
                                                                <div class="mt-4">
                                                                    <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.observation') }}</p>
                                                                    <p>{{ $item->observation }}</p>
                                                                </div>
                                                            @endif
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.status') }}</p>
                                                                <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.user_id') }}</p>
                                                                <p>{{ $item->user->name }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.created_at') }}</p>
                                                                <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashcount.attribute.updated_at') }}</p>
                                                                <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-opening-modal-{{$item->cashcount_uuid}}">
                                                            <div class="bg-[#f3f4f6] p-2">
                                                                <div class="font-bold py-1 text-sm text-center">Saldo en
                                                                    físico
                                                                </div>
                                                            </div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-200-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-100-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-50-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-20-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-10-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-5-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-2-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-1-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-5-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-2-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-1-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-total-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-movement-modal-{{$item->cashcount_uuid}}">
                                                            <div class="bg-[#f3f4f6] p-2">
                                                                <div class="font-bold py-1 text-sm text-center">Saldo en
                                                                    el sistema
                                                                </div>
                                                            </div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-200-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-100-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-50-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-20-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-10-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-5-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-2-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-1-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-5-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-2-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-1-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-total-{{$item->cashcount_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Delete -->
                                    <div id="modal-{{$item->cashcount_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeModal('{{$item->cashcount_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashcount.delete_confirmation')}}
                                                        <strong
                                                            id="name-{{$item->cashcount_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeModal('{{$item->cashcount_uuid}}')">{{ __('Close') }}</button>

                                                    <form action="{{route('cashcounts.destroy',$item->cashcount_uuid)}}"
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

                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginaci車n -->
                    <div class="pagination-wrapper mt-4">
                        {!! $cashcounts->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
