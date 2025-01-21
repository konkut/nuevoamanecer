<x-app-layout>
    <x-slot name="title">
        {{ __('word.control.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.control.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.control.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.control.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.control.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/control/search.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.control.resource.index') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="flex justify-end space-x-2 items-center mb-4">
                        <form method="GET" action="{{ route('control') }}" onchange="this.submit()"
                              class="inline-block">
                            <select name="perPage" class="border border-gray-300 rounded text-sm pr-8 w-36">
                                <option
                                    value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                                <option
                                    value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
                                <option
                                    value="100" {{ $perPage == 100 ? 'selected' : '' }}>{{ __('word.general.100_items') }}</option>
                            </select>
                        </form>
                    </div>
                    <div class="text-black grid grid-cols-1 md:grid-cols-[74%_25%] gap-4">
                        <div class="overflow-x-auto md:overflow-x-hidden">
                            <table id="table_cash" class="w-full border-collapse border-[#2563eb] text-center text-xs">
                                <thead>
                                <tr class="bg-[#d1d5db]" title="Buscar">
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'caja')">{{ __('word.control.attribute.cash_uuid') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'tipo')">{{ __('word.control.attribute.type') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'total')">{{ __('word.control.attribute.total') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'billete 200')">{{ __('word.control.attribute.bill_200') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'billete 100')">{{ __('word.control.attribute.bill_100') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'billete 50')">{{ __('word.control.attribute.bill_50') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'billete 20')">{{ __('word.control.attribute.bill_20') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'billete 10')">{{ __('word.control.attribute.bill_10') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 5')">{{ __('word.control.attribute.coin_5') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 2')">{{ __('word.control.attribute.coin_2') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 1')">{{ __('word.control.attribute.coin_1') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 0.5')">{{ __('word.control.attribute.coin_0_5') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 0.2')">{{ __('word.control.attribute.coin_0_2') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_cash(this, 'moneda 0.1')">{{ __('word.control.attribute.coin_0_1') }}</th>
                                    {{--
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                        title="">{{ __('word.general.actions') }}</th>
                                    --}}
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($denominations as $item)
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200
                                    {{ $last_record->cash_income_uuid === $item->income_uuid && $last_record->cash_income_uuid ||
                                        $last_record->cash_expense_uuid === $item->expense_uuid && $last_record->cash_expense_uuid ||
                                        $last_record->cash_sale_uuid === $item->sale_uuid && $last_record->cash_sale_uuid ? 'bg-yellow-200' : '' }}">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->cashregister->name ?? "" }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            @if($item->type == 2)
                                                APERTURA
                                            @elseif($item->type == 3)
                                                INGRESO
                                            @elseif($item->type == 4)
                                                EGRESO
                                            @elseif($item->type == 5)
                                                ARQUEO
                                            @elseif($item->type == 6)
                                                CIERRE
                                            @endif</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->total }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bill_200 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bill_100 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bill_50 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bill_20 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bill_10 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_5 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_2 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_1 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_0_5 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_0_2 }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->coin_0_1 }}</td>


                                        {{--
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                <button type="button"
                                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                        onclick="openModal('{{ $item->paymentwithoutprice_uuid }}', '{{ implode(', ', $item->services->toArray()) }}')"
                                        title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                        </button>
                        </div>
                        </td>--}}
                                    </tr>
                                    <!-- Modal -->
                                    {{--
                                    <div id="modal-{{$item->paymentwithoutprice_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeModal('{{$item->paymentwithoutprice_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.transactionmethod.delete_confirmation')}}
                                                        <strong
                                                            id="name-{{$item->paymentwithoutprice_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeModal('{{$item->paymentwithoutprice_uuid}}')">{{ __('Close') }}</button>
                                                    <form id="delete-form-{{$item->paymentwithoutprice_uuid}}"
                                                          action="{{route('paymentwithoutprices.destroy',$item->paymentwithoutprice_uuid)}}"
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
                                    --}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="overflow-x-auto md:overflow-x-hidden">
                            <table id="table_bank" class="w-full border-collapse border-[#2563eb] text-center text-xs">
                                <thead>
                                <tr class="bg-[#d1d5db]" title="Buscar">
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_bank(this, 'banco')">{{ __('word.control.attribute.bank_uuid') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_bank(this, 'tipo')">{{ __('word.control.attribute.type') }}</th>
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                        onclick="enable_seach_bank(this, 'total')">{{ __('word.control.attribute.total') }}</th>
                                    {{--
                                    <th class="border-t border-b border-[#d1d5db] px-2 py-1"
                                        title="">{{ __('word.general.actions') }}</th>
                                    --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $item)
                                    <tr class="hover:bg-[#d1d5db44] transition duration-200
                                    {{ $last_record->bank_income_uuid === $item->income_uuid && $last_record->bank_income_uuid ||
                                        $last_record->bank_expense_uuid === $item->expense_uuid && $last_record->bank_expense_uuid ||
                                        $last_record->bank_sale_uuid === $item->sale_uuid && $last_record->bank_sale_uuid ? 'bg-yellow-200' : '' }}">
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->bankregister->name ?? "Sin asignar"}}</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            @if($item->type == 2)
                                                APERTURA
                                            @elseif($item->type == 3)
                                                CRÉDITO
                                            @elseif($item->type == 4)
                                                DÉBITO
                                            @elseif($item->type == 5)
                                                ARQUEO
                                            @elseif($item->type == 6)
                                                CIERRE
                                            @endif</td>
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->total }}</td>
                                        {{--
                                        <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                                            <div class="flex justify-center space-x-1">
                                                <button type="button"
                                                        class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                                        onclick="openModal('{{ $item->paymentwithoutprice_uuid }}', '{{ implode(', ', $item->services->toArray()) }}')"
                                        title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-trash"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                        </button>
                                    </div>
                                    </td>--}}
                                    </tr>
                                    <!-- Modal -->
                                    {{--
                                    <div id="modal-{{$item->paymentwithoutprice_uuid}}"
                                         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                                        <div class="flex items-center justify-center min-h-screen">
                                            <div
                                                class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                                                <div
                                                    class="modal-header p-4 border-b flex justify-between items-center">
                                                    <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                                                    <button type="button"
                                                            class="close-modal text-gray-500 hover:text-gray-700"
                                                            onclick="closeModal('{{$item->paymentwithoutprice_uuid}}')">
                                                        &times;
                                                    </button>
                                                </div>
                                                <div class="modal-body p-6">
                                                    <p class="text-gray-600">{{__('word.transactionmethod.delete_confirmation')}}
                                                        <strong
                                                            id="name-{{$item->paymentwithoutprice_uuid}}"></strong>{{__('word.general.delete_warning')}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                                                    <button type="button"
                                                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400"
                                                            onclick="closeModal('{{$item->paymentwithoutprice_uuid}}')">{{ __('Close') }}</button>
                                                    <form id="delete-form-{{$item->paymentwithoutprice_uuid}}"
                                                          action="{{route('paymentwithoutprices.destroy',$item->paymentwithoutprice_uuid)}}"
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
                                    --}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagination-wrapper mt-4">
                        {!! $denominations->appends(['perPage' => $perPage])->links() !!}
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
