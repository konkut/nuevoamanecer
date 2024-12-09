<x-app-layout>
    <x-slot name="title">
        {{ __('word.payment.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.payment.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.payment.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.payment.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.payment.meta.index.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/fetch_modal_show.js?v='.time()) }}"></script>
    </x-slot>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.payment.resource.index') }}
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

                        <a href="{{ route('paymentwithprices.create') }}"
                           class="bg-blue-400 text-white px-4 py-2 rounded text-sm">
                            <i class="bi bi-plus"></i>
                        </a>

                        <form method="GET" action="{{ route('paymentwithprices.index') }}" onchange="this.submit()"
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
                            <tr class="bg-[#d1d5db]">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'servicio')">{{ __('word.payment.attribute.servicewithoutprice_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'monto')">{{ __('word.payment.attribute.amount') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'método')">{{ __('word.payment.attribute.transactionmethod_uuid') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enableSearch(this, 'fecha de registro')">{{ __('word.payment.attribute.created_at') }}</th>
                                @can('paymentwithpricesuser.showuser')
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enableSearch(this, 'registrado por')">{{ __('word.payment.attribute.user_id') }}</th>
                                @endcan
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">{{ __('word.general.actions') }}</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($paymentwithprices as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        @if (!empty($item->services))
                                            {{ implode(', ', $item->services->toArray()) }}
                                        @else
                                            N/A
                                        @endif</td>
                                    </td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        @if (!empty($item->total))
                                            {{ ($item->total) }}
                                        @else
                                            N/A
                                        @endif</td>
                                    </td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        @if (!empty($item->methods))
                                            {{ implode(', ', $item->methods->toArray()) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->diffForHumans() }}</td>
                                    @can('paymentwithoutpricesuser.showuser')
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->user->name }}</td>
                                    @endcan
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                        <div class="flex justify-center space-x-1">
                                            <form id="details-form-{{$item->paymentwithprice_uuid}}"
                                                  action="{{ route('paymentwithpricesdetail.showdetail', $item->paymentwithprice_uuid) }}"
                                                  method="POST">
                                                @csrf
                                                <button type="button"
                                                        onclick="fetchDetails('{{$item->paymentwithprice_uuid}}')"
                                                        class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('paymentwithprices.edit',$item->paymentwithprice_uuid) }}"
                                               class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                    class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                    onclick="openModal('{{ $item->paymentwithprice_uuid }}', '{{ implode(', ', $item->services->toArray()) }}')">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>

                                <div id="details-modal-{{$item->paymentwithprice_uuid}}"
                                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto">
                                    <div
                                        class="bg-white rounded-lg shadow-lg w-11/12 max-w-3xl mx-auto transform transition-transform scale-100 opacity-100 duration-300">
                                        <div
                                            class="modal-header p-4 bg-gray-100 text-gray-600 flex items-center justify-between rounded-t-lg">
                                            <h1 class="text-lg font-semibold mx-auto">{{ __('word.payment.resource.show') }}</h1>
                                            <button type="button"
                                                    class="text-gray-600 hover:text-gray-900 text-2xl absolute top-4 right-4"
                                                    onclick="closeDetailsModal('{{$item->paymentwithprice_uuid}}')">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body py-6 px-4 sm:px-6 text-gray-700 overflow-hidden">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="text-center">
                                                    @if($item->name)
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.payment.attribute.name') }}</p>
                                                            <p>{{ $item->name }}</p>
                                                        </div>
                                                    @endif
                                                    @if($item->amount)
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.payment.attribute.amount') }}</p>
                                                            <p>{{ $item->amount }}</p>
                                                        </div>
                                                    @endif
                                                    @if($item->commission)
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.payment.attribute.commission') }}</p>
                                                            <p>{{ $item->commission }}</p>
                                                        </div>
                                                    @endif
                                                    @if($item->observation)
                                                        <div class="mt-4">
                                                            <p class="text-sm font-semibold">{{ __('word.payment.attribute.observation') }}</p>
                                                            <p>{{ $item->observation }}</p>
                                                        </div>
                                                    @endif
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold">{{ __('word.payment.attribute.created_at') }}</p>
                                                        <p>{{ $item->created_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold">{{ __('word.payment.attribute.updated_at') }}</p>
                                                        <p>{{ $item->updated_at->format('H:i d/m/Y') }}</p>
                                                    </div>
                                                    <div class="mt-4">
                                                        <p class="text-sm font-semibold">{{ __('word.payment.attribute.user_id') }}</p>
                                                        <p>{{ $item->user->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-center"
                                                     id="modal-show-{{$item->paymentwithprice_uuid}}">
                                                    <div class="contain-bill-coin">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div id="modal-{{$item->paymentwithprice_uuid}}"
                                     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div
                                            class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                            <div class="modal-header p-4 border-b flex justify-between items-center">
                                                <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                <button type="button"
                                                        class="close-modal text-gray-500 hover:text-gray-700"
                                                        onclick="closeModal('{{$item->paymentwithprice_uuid}}')">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body p-6">
                                                <p class="text-gray-600">{{__('word.payment.delete_confirmation')}}
                                                    <strong
                                                        id="name-{{$item->paymentwithprice_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                </p>
                                            </div>
                                            <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                <button type="button"
                                                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                        onclick="closeModal('{{$item->paymentwithprice_uuid}}')">{{ __('Close') }}</button>
                                                <form id="delete-form-{{$item->paymentwithprice_uuid}}"
                                                      action="{{route('paymentwithprices.destroy',$item->paymentwithprice_uuid)}}"
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

                    <!-- Paginaci車n -->
                    <div class="pagination-wrapper mt-4">
                        {!! $paymentwithprices->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
