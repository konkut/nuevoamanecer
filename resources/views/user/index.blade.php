<x-app-layout>
    <x-slot name="title">
        {{ __('word.user.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.user.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.user.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.user.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.user.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/enable_and_disable_modal.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.user.resource.index') }}
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
                        @can('users.create')
                            <a href="{{ route('users.create') }}"
                               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                               title="{{__('word.general.title_icon_create')}}">
                                <i class="bi bi-plus"></i>
                            </a>
                        @endcan
                        <form method="GET" action="{{ route('users.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, '{{ __('word.user.filter.name') }}')">{{ __('word.user.attribute.name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.email') }}')">{{ __('word.user.attribute.email') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.rol') }}')">{{ __('word.user.attribute.rol') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.password_expiration') }}')">{{ __('word.user.attribute.password_expiration') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.created_at') }}')">{{ __('word.user.attribute.created_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.updated_at') }}')">{{ __('word.user.attribute.updated_at') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.user.filter.status') }}')">{{ __('word.user.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                @php
                                    $password_changed_at = \Carbon\Carbon::parse($item->password_changed_at);
                                    $new_date = $password_changed_at->addDays(30);
                                    $days_left = now()->diffInDays($new_date, false);
                                @endphp
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->email}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ implode(', ', $item->rol) }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        @if ($days_left > 0)
                                            {{__('word.user.part_one_expired')}}{{ number_format($days_left,0) }}{{__('word.user.part_two_expired')}}
                                        @else
                                            {{__('word.user.msg_expired')}}
                                        @endif
                                    </td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->updated_at->format('H:i:s d/m/Y') }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        <div class="flex justify-center space-x-1">
                                            @can('users.index')
                                                <a href="javascript:void(0);"
                                                   title="{{__('word.general.title_icon_show')}}"
                                                   class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                                   onclick="openDetailsModal('{{$item->id}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('users.edit')
                                                <a href="{{ route('users.edit', $item->id) }}"
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
                                            @can('users.roles')
                                                <button type="button"
                                                        class="bg-violet-500 text-white px-2 py-1 rounded text-xs"
                                                        onclick="openRoleModal('{{ $item->id }}')"
                                                        title="{{__('word.general.title_icon_role')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-person-plus"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                                        <path fill-rule="evenodd"
                                                              d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </button>
                                            @endcan
                                            @if($item->status)
                                                <button type="button"
                                                        class="bg-pink-400 text-white px-2 py-1 rounded text-xs"
                                                        onclick="open_disable_modal('{{ $item->id }}', '{{ $item->name }}')"
                                                        title="{{__('word.general.title_icon_user_disable')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-person-fill-check"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                        <path
                                                            d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                        onclick="open_enable_modal('{{ $item->id }}', '{{ $item->name }}')"
                                                        title="{{__('word.general.title_icon_user_enable')}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-person-fill-dash"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                        <path
                                                            d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                                    </svg>
                                                </button>
                                            @endif
                                            {{--
                                             @can('users.destroy')
                                                 <button type="button"
                                                         class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                         onclick="openModal('{{ $item->id }}', '{{ $item->name }}')"
                                                         title="{{__('word.general.title_icon_delete')}}">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-dash" viewBox="0 0 16 16">
                                                         <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                         <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                                                     </svg>
                                                 </button>
                                             @endcan
                                            --}}
                                        </div>
                                    </td>
                                </tr>
                                <div id="details-modal-{{$item->id}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto py-3">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-modal-{{$item->id}}">
                                        <div
                                            class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 xl:w-1/5 transform transition-transform scale-100 opacity-100 duration-300">
                                            <div
                                                class="modal-header p-4 {{$item->status ? 'bg-green-200' : 'bg-red-200'}} text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                                <button type="button"
                                                        class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                                                        onclick="closeDetailsModal('{{$item->id}}')">
                                                    &times;
                                                </button>
                                                <h1 class="text-lg font-semibold mx-auto">{{ __('word.user.resource.show') }}</h1>
                                            </div>
                                            <div
                                                class="py-12 px-4 text-slate-600 rounded-b-2xl shadow-inner md:max-w-2xl">
                                                <div class="text-center">
                                                    <div>
                                                        <p class="text-sm font-semibold">{{ __('word.user.attribute.name') }}</p>
                                                        <p>{{ $item->name }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.user.attribute.email') }}</p>
                                                        <p>{{ $item->email }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.user.attribute.created_at') }}</p>
                                                        <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.user.attribute.updated_at') }}</p>
                                                        <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold">{{ __('word.user.attribute.password_changed_at') }}</p>
                                                        {{ $new_date->format('H:i d/m/Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="role-modal-{{$item->id}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-rol-{{$item->id}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.user.assign_roles')}}
                                                    a {{ $item->name }}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700"
                                                        onclick="closeRoleModal('{{$item->id}}')">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <form id="assign-roles-form-{{$item->id}}"
                                                      action="{{ route('users.roles', $item->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                        @foreach($roles as $role)
                                                            <div class="flex items-center">
                                                                <input type="checkbox" name="roles[]"
                                                                       value="{{ $role->id }}"
                                                                       id="role_{{ $role->id }}_{{$item->id}}"
                                                                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded mr-2"
                                                                    {{ in_array($role->id, old('roles', $item->roles->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                                                                <label for="role_{{ $role->id }}_{{$item->id}}"
                                                                       class="text-gray-700">{{ $role->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeRoleModal('{{$item->id}}')">
                                                    {{ __('Close') }}
                                                </button>
                                                <button type="submit" form="assign-roles-form-{{$item->id}}"
                                                        class="bg-violet-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-violet-600">
                                                    {{ __('Save') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="disable-modal-{{$item->id}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-disable-{{$item->id}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.disable_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                        onclick="close_disable_modal('{{$item->id}}')">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.user.disable_confirmation')}}
                                                    <strong
                                                        id="disable-name-{{$item->id}}"></strong>{{__('word.general.disable_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="close_disable_modal('{{$item->id}}')">{{ __('Close') }}</button>
                                                <form action="{{route('users.disable',$item->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="bg-pink-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-pink-600">{{ __('Confirm') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="enable-modal-{{$item->id}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-enable-{{$item->id}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.enable_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                        onclick="close_enable_modal('{{$item->id}}')">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.user.enable_confirmation')}}
                                                    <strong
                                                        id="enable-name-{{$item->id}}"></strong>{{__('word.general.enable_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="close_enable_modal('{{$item->id}}')">{{ __('Close') }}</button>
                                                <form action="{{route('users.enable',$item->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="bg-red-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-red-600">{{ __('Confirm') }}</button>
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
                        {!! $users->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
