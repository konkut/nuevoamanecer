<x-app-layout>
    <x-slot name="title">
        {{ __('word.invoice.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.invoice.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.invoice.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.invoice.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.invoice.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.invoice.resource.index') }}
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
                        <form method="GET" action="{{ route('invoices.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.code') }}')">{{ __('word.invoice.attribute.code') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.services') }}')">{{ __('word.invoice.attribute.services') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.customer') }}')">{{ __('word.invoice.attribute.customer') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.methods') }}')">{{ __('word.invoice.attribute.methods') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.amount') }}')">{{ __('word.invoice.attribute.amount') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.user_id') }}')">{{ __('word.invoice.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.created_at') }}')">{{ __('word.invoice.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.invoice.filter.updated_at') }}')">{{ __('word.invoice.attribute.updated_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $item)
                                @if(auth()->user()->hasRole('Administrador') || $item->user_id == Auth::id())
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->code }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->services }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->customer }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->methods }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->amount }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                @can('invoices.index')
                                                    <a href="javascript:void(0);"
                                                       title="{{__('word.general.title_icon_show')}}"
                                                       class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                                       onclick="openDetailsModal('{{$item->invoice_uuid}}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                            <path
                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                        </svg>
                                                    </a>
                                                @endcan
                                                @can('invoices.create')
                                                    <a href="{{ route('invoices.store', $item->revenue_uuid) }}"
                                                       target="_blank"
                                                       onclick="close_invoice_modal('{{$item->revenue_uuid}}')"
                                                       class="bg-sky-500 text-white px-2 py-1 rounded text-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-receipt"
                                                             viewBox="0 0 16 16">
                                                            <path
                                                                d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                                                            <path
                                                                d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                                                        </svg>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    <div id="details-modal-{{$item->invoice_uuid}}"
                                         class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto py-3">
                                        <div class="flex items-center justify-center min-h-screen"
                                             id="scale-modal-{{$item->invoice_uuid}}">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 bg-green-200 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                    <h1 class="text-lg font-semibold mx-auto">{{ __('word.invoice.resource.show') }}</h1>
                                                    <button type="button"
                                                            class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                            onclick="closeDetailsModal('{{$item->invoice_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body py-6 text-gray-700 overflow-hidden text-center">
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.code') }}</p>
                                                        <p>{{ $item->code }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.services') }}</p>
                                                        <p>{{ $item->services }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.customer') }}</p>
                                                        <p>{{ $item->customer }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.methods') }}</p>
                                                        <p>{{ $item->methods }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.amount') }}</p>
                                                        <p>{{ $item->amount }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.user_id') }}</p>
                                                        <p>{{ $item->user }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.created_at') }}</p>
                                                        <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.invoice.attribute.updated_at') }}</p>
                                                        <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
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
                        {!! $invoices->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
