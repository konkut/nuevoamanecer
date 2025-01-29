<x-app-layout>
    <x-slot name="title">
        {{ __('word.product.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.product.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.product.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.product.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.product.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.product.resource.index') }}
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
                        @can('products.create')
                            <a href="{{ route('products.create') }}"
                               class="bg-blue-400 text-white px-4 py-2 rounded text-sm"
                               title="{{__('word.general.title_icon_create')}}">
                                <i class="bi bi-plus"></i>
                            </a>
                        @endcan
                        <form method="GET" action="{{ route('products.index') }}" onchange="this.submit()"
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
                                    onclick="enableSearch(this, '{{ __('word.product.filter.name') }}')">{{ __('word.product.attribute.name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.product.filter.price') }}')">{{ __('word.product.attribute.price') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.product.filter.stock') }}')">{{ __('word.product.attribute.stock') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.product.filter.created_at') }}')">{{ __('word.product.attribute.created_at') }}</th>
                                @if(auth()->user()->hasRole('Administrador'))
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enableSearch(this, '{{ __('word.product.filter.user_id') }}')">{{ __('word.product.attribute.user_id') }}</th>
                                @endif
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, '{{ __('word.product.filter.status') }}')">{{ __('word.product.attribute.status') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                    title="">{{ __('word.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->price) }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->stock }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->diffForHumans() }}</td>
                                    @if(auth()->user()->hasRole('Administrador'))
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                    @endif
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->status ? '🟢' : '🔴' }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        <div class="flex justify-center space-x-1">
                                            @can('products.index')
                                                <a href="javascript:void(0);"
                                                   title="{{__('word.general.title_icon_show')}}"
                                                   class="bg-green-500 text-white px-2 py-1 rounded text-xs"
                                                   onclick="openDetailsModal('{{$item->product_uuid}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('products.edit')
                                                <a href="{{ route('products.edit',$item->product_uuid) }}"
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
                                            @can('products.destroy')
                                                <button type="button"
                                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                        onclick="openModal('{{ $item->product_uuid }}', '{{ $item->name }}')"
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
                                <div id="details-modal-{{$item->product_uuid}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto py-3">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-modal-{{$item->product_uuid}}">
                                        <div
                                            class="bg-white rounded-2xl shadow-2xl w-5/6 sm:w-3/6 lg:w-2/6 transform transition-transform scale-100 opacity-100 duration-300">
                                            <div
                                                class="modal-header p-4 bg-[#d1d5db] text-slate-600 flex items-center justify-between rounded-t-2xl relative">
                                                <button type="button"
                                                        class="close-modal text-slate-600 hover:text-gray-900 text-3xl absolute right-4"
                                                        onclick="closeDetailsModal('{{$item->product_uuid}}')">
                                                    &times;
                                                </button>
                                                <h1 class="text-lg font-semibold mx-auto">{{ __('word.product.resource.show') }}</h1>
                                            </div>
                                            <div
                                                class="py-12 px-4 text-slate-600 rounded-b-2xl shadow-inner md:max-w-2xl text-center">
                                                <div>
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.name') }}</p>
                                                    <p>{{ $item->name }}</p>
                                                </div>
                                                @if($item->description)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold ">{{ __('word.product.attribute.description') }}</p>
                                                        <p>{{ $item->description }}</p>
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.price') }}</p>
                                                    <p>{{ $item->price }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.stock') }}</p>
                                                    <p>{{ $item->stock }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.category_uuid') }}</p>
                                                    <p>{{ $item->category->name }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.status') }}</p>
                                                    <p>{{ $item->status ? '🟢' : '🔴' }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold">{{ __('word.product.attribute.created_at') }}</p>
                                                    <p> {{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm font-semibold ">{{ __('word.product.attribute.updated_at') }}</p>
                                                    <p> {{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                </div>
                                                @if(auth()->user()->hasRole('Administrador'))
                                                    <div class="mt-2">
                                                        <p class="text-sm font-semibold ">{{ __('word.product.attribute.user_id') }}</p>
                                                        <p> {{ $item->user->name }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-{{$item->product_uuid}}"
                                     class="hidden fixed inset-0 bg-black/60 bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen"
                                         id="scale-delete-{{$item->product_uuid}}">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-5/6 sm:w-3/6 lg:w-2/6 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700 text-2xl"
                                                        onclick="closeModal('{{$item->product_uuid}}')">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.product.delete_confirmation')}}
                                                    <strong
                                                        id="name-{{$item->product_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeModal('{{$item->product_uuid}}')">{{ __('Close') }}</button>
                                                <form id="delete-form-{{$item->product_uuid}}"
                                                      action="{{route('products.destroy',$item->product_uuid)}}"
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
                    <div class="pagination-wrapper mt-4">
                        {!! $products->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
