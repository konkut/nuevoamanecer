<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashshift.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashshift.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashshift.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashshift.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashshift.meta.index.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/fetch_modal_show.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/lock_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/unlock_modal.js?v='.time()) }}"></script>
    </x-slot>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.cashshift.resource.index') }}
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
                        @can('cashshifts.create')
                            <a href="{{ route('cashshifts.create') }}"
                               class="bg-blue-400 text-white w-11 h-9 flex justify-center items-center rounded text-sm"
                               title="Agregar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </a>
                        @endcan
                        <form method="GET" action="{{ route('cashshifts.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, 'fecha de apertura')">{{ __('word.cashshift.attribute.start_time') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'fecha de cierre')">{{ __('word.cashshift.attribute.end_time') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'monto de apertura')">{{ __('word.cashshift.attribute.initial_balance') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'monto de cierre')">{{ __('word.cashshift.attribute.closing_balance') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'caja')">{{ __('word.cashshift.attribute.cashregister_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'cajero')">{{ __('word.cashshift.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'estado')">{{ __('word.cashshift.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashshifts as $item)
                                @php
                                    $validation = \App\Models\Cashcount::where('cashshift_uuid', $item->cashshift_uuid)->where('status', '1')->exists();
                                @endphp
                                @if(auth()->user()->hasRole('Administrador') || $item->user_id == Auth::id())
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->start_time}}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->end_time ?? 'Pendiente' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->initial_balance, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->closing_balance ?? 0, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->cashregister->name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                @if(auth()->user()->hasRole('Administrador'))
                                                    <button type="button"
                                                            title="Habilitar arqueo"
                                                            class="bg-sky-400 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openUnlockModal('{{ $item->cashshift_uuid }}', '{{ $item->created_at }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-unlock"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2M3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                                @if($validation)
                                                    <button type="button"
                                                            title="Cerrar arqueo"
                                                            class="bg-indigo-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openLockModal('{{ $item->cashshift_uuid }}', '{{ $item->created_at }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                                <form id="details-form-{{$item->cashshift_uuid}}"
                                                      title="Visualizar"
                                                      action="{{ route('cashshifts.showdetail', $item->cashshift_uuid) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="button"
                                                            onclick="fetchDetails('{{$item->cashshift_uuid}}')"
                                                            class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </form>
                                                @can('cashshifts.edit')
                                                    <a href="{{ route('cashshifts.edit',$item->cashshift_uuid) }}"
                                                       class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                                       title="Modificar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endcan
                                                @can('cashshifts.destroy')
                                                    <button type="button"
                                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openModal('{{ $item->cashshift_uuid }}', '{{$item->cashregister->name}}')"
                                                            title="Eliminar">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="details-modal-{{$item->cashshift_uuid}}"
                                         class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 max-w-5xl mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-gray-100 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                    <h1 class="text-lg font-semibold mx-auto">{{__('word.cashshift.resource.show')}}</h1>
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body py-6 px-4 sm:px-6 text-gray-700 overflow-hidden">
                                                    <div class="grid grid-cols-1 md:grid-cols-4">
                                                        <div class="text-center pb-8 md:pb-0">
                                                            <div>
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.start_time') }}</p>
                                                                <p>{{ $item->start_time }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.end_time') }}</p>
                                                                <p>{{ $item->end_time ?? "Pendiente" }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.initial_balance') }}</p>
                                                                <p>{{ $item->initial_balance }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.closing_balance') }}</p>
                                                                <p>{{ $item->closing_balance ?? "0.00" }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.cashregister_uuid') }}</p>
                                                                <p>{{ $item->cashregister->name }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.user_id') }}</p>
                                                                <p>{{ $item->user->name }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold ">{{ __('word.cashshift.attribute.status') }}</p>
                                                                <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.created_at') }}</p>
                                                                <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-opening-modal-{{$item->cashshift_uuid}}">
                                                            <div class="bg-[#f3f4f6] p-2">
                                                                <div class="font-bold py-1 text-sm text-center">APERTURA
                                                                    DE CAJA
                                                                </div>
                                                            </div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-total-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-movement-modal-{{$item->cashshift_uuid}}">
                                                            <div class="bg-[#f3f4f6] p-2">
                                                                <div class="font-bold py-1 text-sm text-center">FLUJO DE
                                                                    CAJA
                                                                </div>
                                                            </div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="system-balance-total-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-closing-modal-{{$item->cashshift_uuid}}">
                                                            <div class="bg-[#f3f4f6] p-2">
                                                                <div class="font-bold py-1 text-sm text-center">CIERRE
                                                                    DE CAJA
                                                                </div>
                                                            </div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="total-balance-total-{{$item->cashshift_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Delete -->
                                    <div id="modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeModal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashshift.delete_confirmation')}}
                                                        <strong
                                                            id="name-{{$item->cashshift_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeModal('{{$item->cashshift_uuid}}')">{{ __('Close') }}</button>
                                                    <form
                                                        action="{{route('cashshifts.destroy',$item->cashshift_uuid)}}"
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
                                    <!-- Modal Close Box -->
                                    <div id="lock-modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.cashshift.lock_box_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeLockModal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashshift.lock_box_confirmation')}}
                                                        <strong
                                                            id="name-lock-{{$item->cashshift_uuid}}"></strong>{{__('word.cashshift.lock_box_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeLockModal('{{$item->cashshift_uuid}}')">{{ __('Exit') }}</button>
                                                    <form
                                                        action="{{route('cashshifts.close',$item->cashshift_uuid)}}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-yellow-900 text-white px-4 py-2 rounded transition duration-300 hover:bg-yellow-950">{{ __('Confirm') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Open Box -->
                                    <div id="unlock-modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.cashshift.unlock_box_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeUnlockModal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashshift.unlock_box_confirmation')}}
                                                        <strong
                                                            id="name-unlock-{{$item->cashshift_uuid}}"></strong>{{__('word.cashshift.unlock_box_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeUnlockModal('{{$item->cashshift_uuid}}')">{{ __('Exit') }}</button>
                                                    <form
                                                        action="{{route('cashshifts.open',$item->cashshift_uuid)}}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-yellow-900 text-white px-4 py-2 rounded transition duration-300 hover:bg-yellow-950">{{ __('Confirm') }}</button>
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
                        {!! $cashshifts->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
