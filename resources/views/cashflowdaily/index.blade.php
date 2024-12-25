<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashflowdaily.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashflowdaily.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashflowdaily.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashflowdaily.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashflowdaily.meta.index.description')}}
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
            {{ __('word.cashflowdaily.resource.index') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    @php
        $validation = \App\Models\Cashshift::whereDate('created_at',now())->get();
    @endphp
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end space-x-2 items-center mb-4">

                            <a href="{{ route('cashflowdailies.summary') }}"
                               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                               title="Generar resumen del dia">
                                <i class="bi bi-clipboard-data"></i>
                            </a>

                        <form method="GET" action="{{ route('cashflowdailies.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, 'fecha')">{{ __('word.cashflowdaily.attribute.date') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'total de apertura')">{{ __('word.cashflowdaily.attribute.total_opening') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'total de cierre')">{{ __('word.cashflowdaily.attribute.total_closing') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'total de ingresos')">{{ __('word.cashflowdaily.attribute.total_incomes') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'total de egresos')">{{ __('word.cashflowdaily.attribute.total_expenses') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashflowdailies as $item)
                                @if(auth()->user()->hasRole('Administrador'))
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->date }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->total_opening ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->total_closing ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->total_incomes ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->total_expenses ?? 0.00, 2) }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                <form id="details-form-{{$item->cashflowdaily_uuid}}"
                                                      action="{{ route('cashflowdailies.detail', $item->cashflowdaily_uuid) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="button"
                                                            title="Visualizar"
                                                            onclick="fetchDetails('{{$item->cashflowdaily_uuid}}')"
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
                                                <a href="{{ route('cashflowdailies.report', $item->cashflowdaily_uuid) }}"
                                                   target="_blank"
                                                   title="Generar reporte"
                                                   class="bg-sky-400 text-white px-2 py-1 rounded text-xs">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <div id="details-modal-{{$item->cashflowdaily_uuid}}"
                                         class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-gray-100 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                    <h1 class="text-lg font-semibold mx-auto">{{__('word.cashflowdaily.detail_services')}}</h1>
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->cashflowdaily_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body py-6 px-4 sm:px-6 text-gray-700 overflow-hidden">
                                                    <div class="grid grid-cols-1 md:grid-cols-6">
                                                        <div class="text-center pb-8 md:pb-0">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">DETALLES</div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.date') }}</p>
                                                                <p>{{ $item->date }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.total_opening') }}</p>
                                                                <p>{{ $item->total_opening }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.total_closing') }}</p>
                                                                <p>{{ $item->total_closing }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.total_incomes') }}</p>
                                                                <p>{{ $item->total_incomes }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.total_expenses') }}</p>
                                                                <p>{{ $item->total_expenses }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.total_physical') }}</p>
                                                                <p>{{ $item->total_physical }}</p>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-sm font-semibold">{{ __('word.cashflowdaily.attribute.created_at') }}</p>
                                                                <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-opening-modal-{{$item->cashflowdaily_uuid}}">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">TOTAL APERTURA</div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-bill-200-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-bill-100-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-bill-50-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-bill-20-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-bill-10-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-0-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-0-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-coin-0-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="initial-balance-total-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-incomes-modal-{{$item->cashflowdaily_uuid}}">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">TOTAL INGRESOS</div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-bill-200-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-bill-100-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-bill-50-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-bill-20-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-bill-10-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-0-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-0-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-coin-0-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="incomes-balance-total-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-expenses-modal-{{$item->cashflowdaily_uuid}}">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">TOTAL EGRESOS</div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-bill-200-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-bill-100-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-bill-50-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-bill-20-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-bill-10-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-0-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-0-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-coin-0-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="expenses-balance-total-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-closing-modal-{{$item->cashflowdaily_uuid}}">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">TOTAL DE CIERRE</div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-bill-200-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-bill-100-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-bill-50-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-bill-20-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-bill-10-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-0-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-0-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-coin-0-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="closing-balance-total-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center pb-8 md:pb-0"
                                                             id="show-physical-modal-{{$item->cashflowdaily_uuid}}">
                                                            <div class="bg-gray-50 p-2 font-bold py-1 text-sm text-center">ARQUEO FÍSICO</div>
                                                            <div class="divide-y divide-[#f3f4f6]">
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">200</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-200-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">100</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-100-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">50</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-50-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">20</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-20-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">10</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-bill-10-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.5</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-5-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.2</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-2-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">0.1</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-coin-0-1-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                                <div
                                                                    class="flex hover:bg-[#d1d5db44] transition duration-200 py-1">
                                                                    <div class="w-1/3 text-end">Bs&nbsp;&nbsp;</div>
                                                                    <div class="w-1/3 text-start">Total</div>
                                                                    <div class="w-1/2 text-start"
                                                                         id="physical-balance-total-{{$item->cashflowdaily_uuid}}"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="modal-header p-2 bg-gray-100 text-gray-600 flex flex-row justify-center items-center">
                                                    <h1 class="text-lg font-semibold mx-auto">{{__('word.cashflowdaily.total_services')}}</h1>
                                                </div>
                                                <div class="rounded-b-lg">
                                                    <div class="flex bg-gray-50 p-2 font-bold py-1 text-sm text-center">
                                                        <div
                                                            class="flex-1 text-sm text-gray-700 font-medium text-center">
                                                            SERVICIO
                                                        </div>
                                                        <div
                                                            class="flex-1 text-sm text-gray-700 font-medium text-center">
                                                            CANTIDAD
                                                        </div>
                                                        <div
                                                            class="flex-1 text-sm text-gray-700 font-medium text-center">
                                                            PRECIO
                                                        </div>
                                                        <div
                                                            class="flex-1 text-sm text-gray-700 font-medium text-center">
                                                            COMISIÓN
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="text-center text-gray-700 divide-y divide-[#f3f4f6] rounded-b-lg"
                                                        id="show-services-modal-{{$item->cashflowdaily_uuid}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper mt-4">
                        {!! $cashflowdailies->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
