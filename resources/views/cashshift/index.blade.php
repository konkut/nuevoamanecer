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
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/enable_and_disable_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/cashshift/fetch_detail_cashshift.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/fetch_delete_cashshift.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/fetch_enable_cashshift.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/fetch_disable_cashshift.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.cashshift.resource.index') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end space-x-2 items-center mb-4">
                        @can('cashshifts.create')
                            <a href="{{ route('cashshifts.create') }}"
                               class="bg-blue-400 text-white w-11 h-9 flex justify-center items-center rounded text-sm"
                               title="{{__('word.general.title_icon_create')}}">
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
                            <tr class="bg-[#d1d5db]" title="{{__('word.general.title_icon_filter')}}">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.cashregister_uuid') }}')">{{ __('word.cashshift.attribute.cashregister_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_open') }}')">{{ __('word.cashshift.attribute.total_open') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_close') }}')">{{ __('word.cashshift.attribute.total_close') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.bankregister_uuids') }}')">{{ __('word.cashshift.attribute.bankregister_uuids') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_open') }}')">{{ __('word.cashshift.attribute.total_open') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_close') }}')">{{ __('word.cashshift.attribute.total_close') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.platform_uuids') }}')">{{ __('word.cashshift.attribute.platform_uuids') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_open') }}')">{{ __('word.cashshift.attribute.total_open') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.total_close') }}')">{{ __('word.cashshift.attribute.total_close') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.start_time') }}')">{{ __('word.cashshift.attribute.start_time') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.end_time') }}')">{{ __('word.cashshift.attribute.end_time') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.user_id') }}')">{{ __('word.cashshift.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.cashshift.filter.status') }}')">{{ __('word.cashshift.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cashshifts as $item)
                                @if(auth()->user()->hasRole('Administrador') || $item->user_id == Auth::id())
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->cash_name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->cash_opening_total }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->cash_closing_total ?? 'Pendiente' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bank_name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bank_opening_total }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bank_closing_total == "" ? 'Pendiente' : $item->bank_closing_total }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->platform_name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->platform_opening_total }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->platform_closing_total == "" ? 'Pendiente' : $item->platform_closing_total}}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->start_time}}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->end_time ?? 'Pendiente' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                <a href="{{ route('cashcounts.create',$item->cashshift_uuid) }}"
                                                   class="bg-pink-500 text-white px-2 py-1 rounded text-xs"
                                                   title="{{__('word.general.title_icon_create_cashcount')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                                                        <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                                        <path
                                                            d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
                                                    </svg>
                                                </a>
                                                <form id="details-form-{{$item->cashshift_uuid}}"
                                                      title="{{__('word.general.title_icon_show')}}"
                                                      action="{{ route('cashshifts.detail', $item->cashshift_uuid) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="button"
                                                            onclick="fetch_detail_cashshift('{{url('/')}}', '{{$item->cashshift_uuid}}')"
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
                                                @can('cashshifts.edit')
                                                    <a href="{{ route('cashshifts.edit',$item->cashshift_uuid) }}"
                                                       class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                                       title="{{__('word.general.title_icon_update')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-eyedropper"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708zM2 12.707l7-7L10.293 7l-7 7H2z"/>
                                                        </svg>
                                                    </a>
                                                @endcan
                                                @if($item->status)
                                                    <button type="button"
                                                            class="bg-sky-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="open_disable_modal('{{ $item->cashshift_uuid }}', '{{ $item->cash_name }}')"
                                                            title="{{__('word.general.title_icon_disable')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="16" fill="currentColor"
                                                             class="bi bi-unlock" viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2M3 8a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1z"/>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="bg-sky-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="open_enable_modal('{{ $item->cashshift_uuid }}', '{{ $item->cash_name }}')"
                                                            title="{{__('word.general.title_icon_enable')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="16" fill="currentColor" class="bi bi-lock"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                                @can('cashshifts.destroy')
                                                    <button type="button"
                                                            class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="openModal('{{ $item->cashshift_uuid }}', '{{$item->cash_name}}')"
                                                            title="{{__('word.general.title_icon_delete')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-trash"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                        </svg>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="details-modal-{{$item->cashshift_uuid}}"
                                         class="fixed inset-0 bg-black/60 bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-modal-{{$item->cashshift_uuid}}">
                                            <div
                                                class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5  transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-green-200 text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                    <h1 class="text-lg font-semibold mx-auto">{{__('word.cashshift.resource.show')}}</h1>
                                                </div>
                                                <div class="modal-body py-6 text-gray-700 overflow-hidden text-center">
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.user_id') }}</p>
                                                        <p>{{ $item->user->name }}</p>
                                                    </div>
                                                    @if($item->observation)
                                                        <div class="mt-2">
                                                            <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.observation') }}</p>
                                                            <p>{{ $item->observation }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.start_time') }}</p>
                                                        <p>{{ $item->start_time }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.end_time') }}</p>
                                                        <p>{{ $item->end_time ?? "Pendiente" }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold ">{{ __('word.cashshift.attribute.status') }}</p>
                                                        <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                    </div>

                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.created_at') }}</p>
                                                        <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.cashshift.attribute.updated_at') }}</p>
                                                        <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-denomination-open-{{$item->cashshift_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_denomination_open') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div class="text-start text-gray-700 font-extrabold text-sm py-2">{{__('word.general.one_column')}}</div>
                                                                <div class="text-start">{{__('word.general.200')}}</div>
                                                                <div class="text-start">{{__('word.general.100')}}</div>
                                                                <div class="text-start">{{__('word.general.50')}}</div>
                                                                <div class="text-start">{{__('word.general.20')}}</div>
                                                                <div class="text-start">{{__('word.general.10')}}</div>
                                                                <div class="text-start">{{__('word.general.5')}}</div>
                                                                <div class="text-start">{{__('word.general.2')}}</div>
                                                                <div class="text-start">{{__('word.general.1')}}</div>
                                                                <div class="text-start">{{__('word.general.0_5')}}</div>
                                                                <div class="text-start">{{__('word.general.0_2')}}</div>
                                                                <div class="text-start">{{__('word.general.0_1')}}</div>
                                                                <div class="text-start">{{__('word.general.total')}}</div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.two_column')}}</div>
                                                                <div class="text-center" id="quantity-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="quantity-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div class="text-end text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div class="text-end" id="operation-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="operation-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="total-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-cashregister-open-{{$item->cashshift_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_cashregister_open') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-cashregister-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-cashregister-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-bankregister-open-{{$item->cashshift_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_bankregister_open') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-bankregister-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-bankregister-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-platform-open-{{$item->cashshift_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_platform_open') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-platform-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-platform-open-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-denomination-close-{{$item->cashshift_uuid}}">
                                                        <div class="bg-red-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_denomination_close') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div class="text-start text-gray-700 font-extrabold text-sm py-2">{{__('word.general.one_column')}}</div>
                                                                <div class="text-start">{{__('word.general.200')}}</div>
                                                                <div class="text-start">{{__('word.general.100')}}</div>
                                                                <div class="text-start">{{__('word.general.50')}}</div>
                                                                <div class="text-start">{{__('word.general.20')}}</div>
                                                                <div class="text-start">{{__('word.general.10')}}</div>
                                                                <div class="text-start">{{__('word.general.5')}}</div>
                                                                <div class="text-start">{{__('word.general.2')}}</div>
                                                                <div class="text-start">{{__('word.general.1')}}</div>
                                                                <div class="text-start">{{__('word.general.0_5')}}</div>
                                                                <div class="text-start">{{__('word.general.0_2')}}</div>
                                                                <div class="text-start">{{__('word.general.0_1')}}</div>
                                                                <div class="text-start">{{__('word.general.total')}}</div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.two_column')}}</div>
                                                                <div class="text-center" id="value-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-center" id="value-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div class="text-end text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div class="text-end" id="amount-bill-200-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-bill-100-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-bill-50-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-bill-20-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-bill-10-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-0-5-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-0-2-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="amount-coin-0-1-{{$item->cashshift_uuid}}"></div>
                                                                <div class="text-end" id="total-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-cashregister-close-{{$item->cashshift_uuid}}">
                                                        <div class="bg-red-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_cashregister_close') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-cashregister-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-cashregister-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-bankregister-close-{{$item->cashshift_uuid}}">
                                                        <div class="bg-red-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_bankregister_close') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-bankregister-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-bankregister-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-platform-close-{{$item->cashshift_uuid}}">
                                                        <div class="bg-red-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.title_platform_close') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-platform-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-platform-close-{{$item->cashshift_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-delete-{{$item->cashshift_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
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
                                                        method="POST"
                                                        onsubmit="fetch_delete_cashshift(this, '{{url('/')}}', '{{ $item->cashshift_uuid }}', event)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="bg-red-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-red-600">{{ __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="disable-modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-disable-{{$item->cashshift_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.disable_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                            onclick="close_disable_modal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashshift.disable_confirmation')}}
                                                        <strong id="disable-name-{{$item->cashshift_uuid}}"></strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="close_disable_modal('{{$item->cashshift_uuid}}')">{{ __('Close') }}</button>
                                                    <form action="{{route('cashshifts.disable',$item->cashshift_uuid)}}"
                                                          method="POST"
                                                          onsubmit="fetch_disable_cashshift(this, '{{url('/')}}', '{{ $item->cashshift_uuid }}', event)">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                                class="bg-sky-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-sky-600">{{ __('Confirm') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="enable-modal-{{$item->cashshift_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-enable-{{$item->cashshift_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.enable_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                            onclick="close_enable_modal('{{$item->cashshift_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.cashshift.enable_confirmation')}}
                                                        <strong id="enable-name-{{$item->cashshift_uuid}}"></strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="close_enable_modal('{{$item->cashshift_uuid}}')">{{ __('Close') }}</button>
                                                    <form action="{{route('cashshifts.enable',$item->cashshift_uuid)}}"
                                                          method="POST"
                                                          onsubmit="fetch_enable_cashshift(this, '{{url('/')}}', '{{ $item->cashshift_uuid }}', event)">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                                class="bg-sky-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-sky-600">{{ __('Confirm') }}</button>
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
                    <div class="pagination-wrapper mt-4">
                        {!! $cashshifts->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
