<div class="container mx-auto p-4">
    <div class="flex justify-end space-x-2 items-center mb-4">
        @can('accountgroups.create')
            <a href="javascript:void(0);"
               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
               title="{{__('word.general.title_icon_create')}}"
               onclick="open_create_modal('accountgroup');">
                <i class="bi bi-plus"></i>
            </a>
        @endcan
        <form method="GET" action="{{ route('accounts.index') }}" onchange="this.submit()"
              class="inline-block">
            <select name="perpage_accountgroups" class="border border-gray-300 rounded text-sm pr-8 w-36">
                <option
                    value="10" {{ $perpage_accountgroups == 10 ? 'selected' : '' }}>{{ __('word.general.10_items') }}</option>
                <option
                    value="20" {{ $perpage_accountgroups == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                <option
                    value="50" {{ $perpage_accountgroups == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
            </select>
        </form>
    </div>
    <div class="overflow-x-auto text-black">
        <table class="min-w-full border-collapse border-[#2563eb] text-center text-sm">
            <thead>
            <tr class="bg-[#d1d5db]" title="{{__('word.general.title_icon_filter')}}">
                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.code') }}')">{{ __('word.account.attribute.code') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.name') }}')">{{ __('word.account.attribute.name') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.accountclass_uuid') }}')">{{ __('word.account.attribute.accountclass_uuid') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.user_id') }}')">{{ __('word.account.attribute.user_id') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.created_at') }}')">{{ __('word.account.attribute.created_at') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.updated_at') }}')">{{ __('word.account.attribute.updated_at') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                    onclick="enableSearch(this, '{{ __('word.account.attribute.status') }}')">{{ __('word.account.attribute.status') }}</th>
                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                    title="">{{ __('word.general.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accountgroups as $item)
                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->code }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->accountclass->name }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                        <div class="flex justify-center space-x-1">
                            @can('accountgroups.index')
                                <a href="javascript:void(0);"
                                   title="{{__('word.general.title_icon_show')}}"
                                   class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                   onclick="openDetailsModal('{{$item->accountgroup_uuid}}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                    </svg>
                                </a>
                            @endcan
                            @can('accountgroups.edit')
                                <a href="{{ route('accountgroups.edit',$item->accountgroup_uuid) }}"
                                   class="bg-yellow-500 text-white px-2 py-1 rounded text-xs"
                                   title="{{__('word.general.title_icon_update')}}"
                                   onclick="fetch_edit_accountgroup(this, '{{url('/')}}', '{{ $item->accountgroup_uuid }}', event);">
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
                                        onclick="open_disable_modal('{{ $item->accountgroup_uuid }}', '{{ $item->name }}')"
                                        title="{{__('word.general.title_icon_disable')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-toggle-on"
                                         viewBox="0 0 16 16">
                                        <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8"/>
                                    </svg>
                                </button>
                            @else
                                <button type="button"
                                        class="bg-sky-500 text-white px-2 py-1 rounded text-xs"
                                        onclick="open_enable_modal('{{ $item->accountgroup_uuid }}', '{{ $item->name }}')"
                                        title="{{__('word.general.title_icon_enable')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-toggle-off"
                                         viewBox="0 0 16 16">
                                        <path d="M11 4a4 4 0 0 1 0 8H8a5 5 0 0 0 2-4 5 5 0 0 0-2-4zm-6 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8M0 8a5 5 0 0 0 5 5h6a5 5 0 0 0 0-10H5a5 5 0 0 0-5 5"/>
                                    </svg>
                                </button>
                            @endif
                            @can('accountgroups.destroy')
                                <button type="button"
                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                        onclick="openModal('{{ $item->accountgroup_uuid }}', '{{ $item->name }}')"
                                        title="{{__('word.general.title_icon_delete')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
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
                <div id="edit-modal-{{$item->accountgroup_uuid}}"
                     class="fixed inset-0 bg-black/60 bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                    <div class="flex items-center justify-center min-h-screen"
                         id="scale-edit-{{$item->accountgroup_uuid}}">
                        <div class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 transform transition-transform scale-100 opacity-100 duration-300">
                            <div class="modal-header p-4 bg-yellow-200 text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                <button type="button"
                                        class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                                        onclick="close_edit_modal('{{$item->accountgroup_uuid}}')">
                                    &times;
                                </button>
                                <h1 class="text-lg font-semibold mx-auto">{{ __('word.accountgroup.resource.edit') }}</h1>
                            </div>
                            <div class="py-12 px-4 rounded-b-2xl shadow-inner md:max-w-2xl">
                                <form method="POST"
                                      action="{{route('accountgroups.update', $item->accountgroup_uuid)}}">
                                    @csrf
                                    @method("PUT" )
                                    @php
                                        $accountgroup->accountgroup_uuid = $item->accountgroup_uuid;
                                    @endphp
                                    <x-form-accountgroup :accountgroup="$accountgroup" :allaccountclasses="$all_accountclasses" page="edit"/>
                                    <div class="mt-4 flex justify-end">
                                        <x-button>
                                            {{ __('Save') }}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="details-modal-{{$item->accountgroup_uuid}}"
                     class="fixed inset-0 bg-black/60 bg-opacity-50 z-50 hidden overflow-y-auto py-3">
                    <div class="flex items-center justify-center min-h-screen"
                         id="scale-modal-{{$item->accountgroup_uuid}}">
                        <div class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 transform transition-transform scale-100 opacity-100 duration-300">
                            <div class="modal-header p-4 {{$item->status ? 'bg-green-200' : 'bg-red-200'}}  text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                <button type="button"
                                        class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                                        onclick="closeDetailsModal('{{$item->accountgroup_uuid}}')">
                                    &times;
                                </button>
                                <h1 class="text-lg font-semibold mx-auto">{{ __('word.accountgroup.resource.show') }}</h1>
                            </div>
                            <div class="py-12 px-4 text-slate-600 rounded-b-2xl shadow-inner md:max-w-2xl">
                                <div class="text-center">
                                    <div>
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.code') }}</p>
                                        <p>{{ $item->code }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.name') }}</p>
                                        <p>{{ $item->name }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.accountclass_uuid') }}</p>
                                        <p>{{ $item->accountclass->name }}</p>
                                    </div>
                                    @if($item->description)
                                        <div class="mt-2">
                                            <p class="text-sm font-semibold ">{{ __('word.account.attribute.description') }}</p>
                                            <p>{{ $item->description }}</p>
                                        </div>
                                    @endif
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.status') }}</p>
                                        <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold">{{ __('word.account.attribute.created_at') }}</p>
                                        <p> {{ $item->created_at->format('H:i d/m/Y') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.updated_at') }}</p>
                                        <p> {{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm font-semibold ">{{ __('word.account.attribute.user_id') }}</p>
                                        <p>{{ $item->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="disable-modal-{{$item->accountgroup_uuid}}"
                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen"
                         id="scale-disable-{{$item->accountgroup_uuid}}">
                        <div
                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.disable_title')}}</h1>
                                <button type="button"
                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                        onclick="close_disable_modal('{{$item->accountgroup_uuid}}')">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body p-6">
                                <p class="text-gray-600">{{__('word.accountgroup.disable_confirmation')}}
                                    <strong id="disable-name-{{$item->accountgroup_uuid}}"></strong>?
                                </p>
                            </div>
                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                <button type="button"
                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                        onclick="close_disable_modal('{{$item->accountgroup_uuid}}')">{{ __('Close') }}</button>
                                <form
                                    action="{{route('accountgroups.disable',$item->accountgroup_uuid)}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="bg-sky-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-sky-600">{{ __('Confirm') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="enable-modal-{{$item->accountgroup_uuid}}"
                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen"
                         id="scale-enable-{{$item->accountgroup_uuid}}">
                        <div class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.enable_title')}}</h1>
                                <button type="button"
                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                        onclick="close_enable_modal('{{$item->accountgroup_uuid}}')">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body p-6">
                                <p class="text-gray-600">{{__('word.accountgroup.enable_confirmation')}}
                                    <strong id="enable-name-{{$item->accountgroup_uuid}}"></strong>?
                                </p>
                            </div>
                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                <button type="button"
                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                        onclick="close_enable_modal('{{$item->accountgroup_uuid}}')">{{ __('Close') }}</button>
                                <form
                                    action="{{route('accountgroups.enable',$item->accountgroup_uuid)}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="bg-sky-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-sky-600">{{ __('Confirm') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-{{$item->accountgroup_uuid}}"
                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen"
                         id="scale-delete-{{$item->accountgroup_uuid}}">
                        <div class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                <button type="button"
                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                        onclick="closeModal('{{$item->accountgroup_uuid}}')">&times;
                                </button>
                            </div>
                            <div class="modal-body p-6">
                                <p class="text-gray-600">{{__('word.accountgroup.delete_confirmation')}}
                                    <strong id="name-{{$item->accountgroup_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                </p>
                            </div>
                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                <button type="button"
                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                        onclick="closeModal('{{$item->accountgroup_uuid}}')">{{ __('Close') }}</button>
                                <form id="delete-form-{{$item->accountgroup_uuid}}"
                                      action="{{route('accountgroups.destroy',$item->accountgroup_uuid)}}"
                                      method="POST"
                                      onsubmit="fetch_delete(this, '{{url('/')}}', '{{ $item->accountgroup_uuid }}', event)">
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
    <div id="create-modal-accountgroup"
         class="fixed inset-0 bg-black/60 bg-opacity-50 z-50 hidden overflow-y-auto py-3">
        <div class="flex items-center justify-center min-h-screen" id="scale-modal-accountgroup">
            <div class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 transform transition-transform scale-100 opacity-100 duration-300">
                <div class="modal-header p-4 bg-blue-200 text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                    <button type="button"
                            class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                            onclick="close_create_modal('accountgroup')">
                        &times;
                    </button>
                    <h1 class="text-lg font-semibold mx-auto">{{ __('word.accountgroup.resource.create') }}</h1>
                </div>
                <div class="py-12 px-4 rounded-b-2xl shadow-inner md:max-w-2xl">
                    <form method="POST" action="{{ route('accountgroups.store') }}">
                        @csrf
                        <x-form-accountgroup :accountgroup="$accountgroup" :allaccountclasses="$all_accountclasses" page="create"/>
                        <div class="mt-4 flex justify-end">
                            <x-button>
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination-wrapper mt-4">
        {!! $accountgroups->appends(['perpage_accountgroups' => $perpage_accountgroups])->links() !!}
    </div>
</div>
