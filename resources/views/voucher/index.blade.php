<x-app-layout>
    <x-slot name="title">
        {{ __('word.voucher.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.voucher.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.voucher.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.voucher.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.voucher.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/enable_and_disable_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/fetch_delete.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.voucher.resource.index') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end space-x-2 items-center mb-4">
                        <a href="{{ route('vouchers.create') }}"
                           class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                           title="{{__('word.general.title_icon_create')}}">
                            <i class="bi bi-plus"></i>
                        </a>
                        <form method="GET" action="{{ route('vouchers.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.number') }}')">{{ __('word.voucher.attribute.number') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.type') }}')">{{ __('word.voucher.attribute.type') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.date') }}')">{{ __('word.voucher.attribute.date') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.project_uuid') }}')">{{ __('word.voucher.attribute.project_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.company_uuid') }}')">{{ __('word.voucher.attribute.company_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.debit') }}')">{{ __('word.voucher.attribute.debit') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.credit') }}')">{{ __('word.voucher.attribute.credit') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.user_id') }}')">{{ __('word.voucher.attribute.user_id') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.created_at') }}')">{{ __('word.voucher.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.voucher.filter.updated_at') }}')">{{ __('word.voucher.attribute.updated_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vouchers as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->number}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        @if($item->type == '1')
                                            Traspaso
                                        @elseif($item->type == '2')
                                            Ingreso
                                        @elseif($item->type == '3')
                                            Egreso
                                        @endif
                                    </td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->date}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->project->name}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->company}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->debit}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->credit}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        <div class="flex justify-center space-x-1">
                                            @can('vouchers.index')
                                                <a href="javascript:void(0);"
                                                   title="{{__('word.general.title_icon_show')}}"
                                                   class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                                   onclick="openDetailsModal('{{$item->voucher_uuid}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('vouchers.edit')
                                                <a href="{{ route('vouchers.edit',$item->voucher_uuid) }}"
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
                                            <button type="button"
                                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                    onclick="openModal('{{ $item->voucher_uuid }}', '{{$item->name }}')"
                                                    title="{{__('word.general.title_icon_delete')}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <div id="details-modal-{{$item->voucher_uuid}}"
                                     class="fixed inset-0 bg-black/60 bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-modal-{{$item->voucher_uuid}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                            <div
                                                class="modal-header p-4 bg-green-200 text-gray-600 flex items-center justify-between rounded-t-lg">
                                                <h1 class="text-lg font-semibold mx-auto">{{__('word.voucher.resource.show')}}</h1>
                                                <button type="button"
                                                        class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                        onclick="closeDetailsModal('{{$item->voucher_uuid}}')">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body py-6 text-gray-700 overflow-hidden text-center px-1">
                                                <div>
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.number') }}</p>
                                                    <p>{{ $item->number }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.type') }}</p>
                                                    <p>
                                                        @if($item->type == '1')
                                                            Traspaso
                                                        @elseif($item->type == '2')
                                                            Ingreso
                                                        @elseif($item->type == '3')
                                                            Egreso
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.date') }}</p>
                                                    <p>{{ $item->date }}</p>
                                                </div>
                                                @if($item->narration)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.voucher.attribute.narration') }}</p>
                                                        <p>{{ $item->narration }}</p>
                                                    </div>
                                                @endif
                                                @if($item->cheque_number)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.voucher.attribute.cheque_number') }}</p>
                                                        <p>{{ $item->cheque_number }}</p>
                                                    </div>
                                                @endif
                                                @if($item->ufv)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.voucher.attribute.ufv') }}</p>
                                                        <p>{{ $item->ufv }}</p>
                                                    </div>
                                                @endif
                                                @if($item->usd)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.voucher.attribute.usd') }}</p>
                                                        <p>{{ $item->usd }}</p>
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.company_uuid') }}</p>
                                                    <p>{{ $item->company }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.project_uuid') }}</p>
                                                    <p>{{ $item->project->name }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.user_id') }}</p>
                                                    <p>{{ $item->user->name }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.created_at') }}</p>
                                                    <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.voucher.attribute.updated_at') }}</p>
                                                    <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                </div>
                                                <div class="text-center py-6 md:pb-0">
                                                    <div class="bg-green-200 p-2">
                                                        <h1 class="font-bold py-1 text-md text-center">{{ __('word.voucher.detail') }}</h1>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-y-2 px-8 py-4 text-sm text-gray-700">
                                                        <div class="text-start text-gray-700 font-extrabold text-sm py-2 border-b-2">{{__('word.voucher.account')}}</div>
                                                        <div class="text-center text-gray-700 font-extrabold text-sm py-2 border-b-2">{{__('word.voucher.debit')}}</div>
                                                        <div class="text-end text-gray-700 font-extrabold text-sm py-2 border-b-2">{{__('word.voucher.credit')}}</div>
                                                        @foreach($item->data as $detail)
                                                            <div class="text-start border-b-2">{{$detail->account->name}}</div>
                                                            <div class="text-center border-b-2">{{$detail->debit}}</div>
                                                            <div class="text-end border-b-2">{{$detail->credit}}</div>
                                                        @endforeach
                                                        <div class="text-start font-extrabold border-b-2">{{__('word.voucher.total') }}</div>
                                                        <div class="text-center font-extrabold border-b-2">{{ $item->debit }}</div>
                                                        <div class="text-end font-extrabold border-b-2">{{ $item->credit }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-{{$item->voucher_uuid}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-delete-{{$item->voucher_uuid}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                        onclick="closeModal('{{$item->voucher_uuid}}')">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.voucher.delete_confirmation')}}
                                                    <strong
                                                        id="name-{{$item->voucher_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeModal('{{$item->voucher_uuid}}')">{{ __('Close') }}</button>
                                                <form action="{{route('vouchers.destroy',$item->voucher_uuid)}}"
                                                      method="POST"
                                                      onsubmit="fetch_delete(this, '{{url('/')}}', '{{ $item->voucher_uuid }}', event)">
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
                    <div class="pagination-wrapper mt-4">
                        {!! $vouchers->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
