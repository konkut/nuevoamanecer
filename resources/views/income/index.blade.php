<x-app-layout>
    <x-slot name="title">
        {{ __('word.income.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.income.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.income.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.income.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.income.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/income/receipt_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/income/fetch_detail_income.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/components/filter_excel.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.income.resource.index') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end gap-4 items-end mb-4 flex-wrap flex-col sm:flex-row">
                        @can('incomes.create')
                            @if($cashshift)
                                <a href="{{ route('incomes.create') }}"
                                   title="{{__('word.general.title_icon_create')}}"
                                   class="bg-blue-400 text-white w-11 h-9 flex justify-center items-center rounded text-sm">
                                    <i class="bi bi-plus"></i>
                                </a>
                            @endif
                        @endcan
                        @can('incomes.export')
                            <form method="GET" action="{{ route('incomes.export') }}"
                                  class="flex flex-row justify-end items-center gap-4 flex-wrap">
                                <label for="filter"
                                       class="text-sm text-gray-600">{{__('word.general.filter_excel')}}</label>
                                <select name="filter" id="filter"
                                        class="border border-gray-300 rounded text-sm pr-8 w-36">
                                    <option value="day">{{__('word.general.filter_today')}}</option>
                                    <option value="week">{{__('word.general.filter_week')}}</option>
                                    <option value="month">{{__('word.general.filter_month')}}</option>
                                    <option value="custom">{{__('word.general.filter_range')}}</option>
                                </select>
                                <div id="custom-range" style="display: none;"
                                     class="flex-wrap flex-col sm:flex-row items-end gap-4">
                                    <div class="space-x-4">
                                        <label for="start_date"
                                               class="text-sm text-gray-600">{{__('word.general.filter_range_start')}}</label>
                                        <input type="date" name="start_date" id="start_date"
                                               class="border border-gray-300 p-2 rounded text-gray-600">
                                    </div>
                                    <div class="space-x-4">
                                        <label for="end_date"
                                               class="text-sm text-gray-600">{{__('word.general.filter_range_end')}}</label>
                                        <input type="date" name="end_date" id="end_date"
                                               class="border border-gray-300 p-2 rounded text-gray-600">
                                    </div>
                                </div>
                                <button type="submit" title="{{__('word.general.title_icon_excel_generate')}}"
                                        class="bg-lime-400 text-white w-11 h-9 flex justify-center items-center rounded text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path
                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                                    </svg>
                                </button>
                            </form>
                        @endcan
                        <form method="GET" action="{{ route('incomes.index') }}" onchange="this.submit()"
                              class="flex flex-row justify-center items-center gap-4 flex-wrap">
                            <label for="perPage"
                                   class="text-sm text-gray-600">{{__('word.general.filter_show')}}</label>
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
                                    onclick="enableSearch(this, '{{ __('word.income.filter.service_uuid') }}')">{{ __('word.income.attribute.service_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.input_name') }}')">{{ __('word.income.attribute.input_name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.input_amount') }}')">{{ __('word.income.attribute.input_amount') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.output_name') }}')">{{ __('word.income.attribute.output_name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.output_amount') }}')">{{ __('word.income.attribute.output_amount') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.user_id') }}')">{{ __('word.income.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.created_at') }}')">{{ __('word.income.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.income.filter.updated_at') }}')">{{ __('word.income.attribute.updated_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($incomes as $item)
                                @if(auth()->user()->hasRole('Administrador') || $item->user_id == Auth::id())
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->names }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->input_name }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->input_total, 2, '.', '') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{$item->output_name ?? '--'}}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->output_total, 2) == 0 ? "--" : number_format($item->output_total, 2, '.', '') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                @can('receipts.create')
                                                    <button type="button"
                                                            class="bg-sky-500 text-white px-2 py-1 rounded text-xs"
                                                            onclick="open_receipt_modal('{{ $item->income_uuid }}', '{{ $item->names }}')"
                                                            title="{{__('word.general.title_icon_tax_generate')}}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-receipt"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                                                            <path
                                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                                                        </svg>
                                                    </button>
                                                @endcan
                                                @can('incomes.detail')
                                                    <form id="details-form-{{$item->income_uuid}}"
                                                          title="{{__('word.general.title_icon_show')}}"
                                                          action="{{ route('incomes.detail', $item->income_uuid) }}"
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="button"
                                                                onclick="fetch_detail_income('{{url('/')}}', '{{$item->income_uuid}}')"
                                                                class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-eye"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                                <path
                                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                                @if($cashshift && $item->cashshift_uuid == $cashshift->cashshift_uuid)
                                                    @can('incomes.edit')
                                                        <a href="{{ route('incomes.edit',$item->income_uuid) }}"
                                                           class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                                           title="{{__('word.general.title_icon_update')}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-eyedropper"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M13.354.646a1.207 1.207 0 0 0-1.708 0L8.5 3.793l-.646-.647a.5.5 0 1 0-.708.708L8.293 5l-7.147 7.146A.5.5 0 0 0 1 12.5v1.793l-.854.853a.5.5 0 1 0 .708.707L1.707 15H3.5a.5.5 0 0 0 .354-.146L11 7.707l1.146 1.147a.5.5 0 0 0 .708-.708l-.647-.646 3.147-3.146a1.207 1.207 0 0 0 0-1.708zM2 12.707l7-7L10.293 7l-7 7H2z"/>
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                    @can('incomes.destroy')
                                                        <button type="button"
                                                                class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                                onclick="openModal('{{ $item->income_uuid }}', '{{ $item->names }}')"
                                                                title="{{__('word.general.title_icon_delete')}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-trash"
                                                                 viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                            </svg>
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="receipt-modal-{{$item->income_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-receipt-{{$item->income_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.receipt_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                            onclick="close_receipt_modal('{{$item->income_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.income.generate_receipt')}}
                                                        <strong id="receipt-name-{{$item->income_uuid}}"></strong>?
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="close_receipt_modal('{{$item->income_uuid}}')">{{ __('Close') }}</button>
                                                    <a href="{{ route('receipts.store', $item->income_uuid) }}"
                                                       target="_blank"
                                                       onclick="close_receipt_modal('{{$item->income_uuid}}')"
                                                       class="bg-sky-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-sky-600">
                                                        {{ __('Confirm') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="details-modal-{{$item->income_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-modal-{{$item->income_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-green-200 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                    <h1 class="text-lg font-semibold mx-auto">{{ __('word.income.resource.show') }}</h1>
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->income_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body py-6 text-gray-700 overflow-hidden text-center">
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.income.attribute.service_uuid') }}</p>
                                                        @foreach($item->detail as $value)
                                                            <div
                                                                class="flex flex-row justify-center items-center">
                                                                <p class="text-center">{{ $value->quantity }}&nbsp;&nbsp;{{ $value->name }}
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($value->price, 2, '.', '') }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if($item->observation)
                                                        <div class="mt-2">
                                                            <p class="text-sm font-semibold">{{ __('word.income.attribute.observation') }}</p>
                                                            <p>{{ $item->observation }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.income.attribute.created_at') }}</p>
                                                        <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.income.attribute.updated_at') }}</p>
                                                        <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    @if(auth()->user()->hasRole('Administrador'))
                                                        <div class="mt-2">
                                                            <p class="text-sm font-semibold">{{ __('word.income.attribute.user_id') }}</p>
                                                            <p>{{ $item->user }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-denomination-input-{{$item->income_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.show_denomination_input') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-start text-gray-700 font-extrabold text-sm py-2">{{__('word.general.one_column')}}</div>
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
                                                                <div
                                                                    class="text-start">{{__('word.general.total')}}</div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.two_column')}}</div>
                                                                <div class="text-center"
                                                                     id="quantity-bill-200-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-bill-100-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-bill-50-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-bill-20-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-bill-10-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-0-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-0-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="quantity-coin-0-1-{{$item->income_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-end text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div class="text-end"
                                                                     id="operation-bill-200-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-bill-100-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-bill-50-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-bill-20-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-bill-10-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-0-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-0-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="operation-coin-0-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="total-{{$item->income_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-denomination-output-{{$item->income_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.show_denomination_output') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-start text-gray-700 font-extrabold text-sm py-2">{{__('word.general.one_column')}}</div>
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
                                                                <div
                                                                    class="text-start">{{__('word.general.total')}}</div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.two_column')}}</div>
                                                                <div class="text-center"
                                                                     id="value-bill-200-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-bill-100-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-bill-50-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-bill-20-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-bill-10-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-0-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-0-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-center"
                                                                     id="value-coin-0-1-{{$item->income_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-end text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div class="text-end"
                                                                     id="amount-bill-200-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-bill-100-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-bill-50-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-bill-20-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-bill-10-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-0-5-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-0-2-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="amount-coin-0-1-{{$item->income_uuid}}"></div>
                                                                <div class="text-end"
                                                                     id="total-payment-{{$item->income_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-cashregister-{{$item->income_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.show_cashregister') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-cashregister-{{$item->income_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-cashregister-{{$item->income_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-bankregister-{{$item->income_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.show_bankregister') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div
                                                                    id="method-bankregister-{{$item->income_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div
                                                                    id="total-bankregister-{{$item->income_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center py-6 md:pb-0 hidden"
                                                         id="modal-platform-{{$item->income_uuid}}">
                                                        <div class="bg-green-200 p-2">
                                                            <h1 class="font-bold py-1 text-md text-center">{{ __('word.general.show_platform') }}</h1>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4 px-8">
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.four_column')}}</div>
                                                                <div id="method-platform-{{$item->income_uuid}}"></div>
                                                            </div>
                                                            <div class="col-span-1">
                                                                <div
                                                                    class="text-center text-gray-700 font-extrabold text-sm py-2">{{__('word.general.three_column')}}</div>
                                                                <div id="total-platform-{{$item->income_uuid}}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="modal-{{$item->income_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-delete-{{$item->income_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                            onclick="closeModal('{{$item->income_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.income.delete_confirmation')}}
                                                        <strong
                                                            id="name-{{$item->income_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeModal('{{$item->income_uuid}}')">{{ __('Close') }}</button>
                                                    <form id="delete-form-{{$item->income_uuid}}"
                                                          action="{{route('incomes.destroy',$item->income_uuid)}}"
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
                    <div class="pagination-wrapper mt-4">
                        {!! $incomes->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
