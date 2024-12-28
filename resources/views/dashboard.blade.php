<x-app-layout>
    <x-slot name="title">
        {{ __('word.dashboard.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.dashboard.meta.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.dashboard.meta.keywords')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12">
        @if($data)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-center text-gray-800 rounded-lg shadow-md">
                        <div class="flex flex-col items-center">
                            <p class="text-2xl font-extrabold text-gray-700 mb-2">Estado de la Sesión de Caja</p>
                            <div class="relative flex items-center mb-2"><span id="toggleStatus" class="mr-2 text-gray-700 {{ $cashshift->status ? 'text-green-500' : 'text-red-500' }}">{{ $cashshift->status ? 'Habilitado' : 'Deshabilitado' }}</span>
                                <form action="{{route('dashboards.state',$cashshift->cashshift_uuid)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" id="toggleButton"
                                            class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $cashshift->status ? 'bg-green-500' : 'bg-red-500' }}"
                                            onclick="toggleStatus()">
                                        <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $cashshift->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                                    </button>
                                    <input type="hidden" name="status" id="status"
                                           value="{{ $cashshift->status ? '1' : '0' }}">
                                </form>
                            </div>
                            <p class="text-lg text-gray-500 mb-4">Detalles de la sesión actual</p>
                            <div class="bg-gray-100 w-full max-w-md rounded-lg p-4 text-center text-sm text-gray-600 space-y-3">
                                <p><span class="font-semibold text-gray-700">Caja asignada:</span> {{$cashshift->cashregister->name}}</p>
                                <p><span class="font-semibold text-gray-700">Responsable:</span> {{$cashshift->user->name}}</p>
                                <p><span class="font-semibold text-gray-700">Hora de apertura:</span> {{$cashshift->start_time}}</p>
                                <p><span class="font-semibold text-gray-700">Hora de cierre:</span> {{$cashshift->end_time??'Pendiente'}}</p>
                                @if($cashshift->observation)
                                    <p><span class="font-semibold text-gray-700">Observaciones:</span> {{$cashshift->observation}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 text-slate-700 rounded-lg shadow-md">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-opening-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">TOTAL DE APERTURA</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}" alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-bill-200">{{$data['opening']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}" alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-bill-100">{{$data['opening']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}" alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-bill-50">{{$data['opening']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}" alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-bill-20">{{$data['opening']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}" alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-bill-10">{{$data['opening']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-5">{{$data['opening']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-2">{{$data['opening']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-1">{{$data['opening']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-0-5">{{$data['opening']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-0-2">{{$data['opening']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-coin-0-1">{{$data['opening']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['opening']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="initial-balance-total">{{$data['opening']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-incomes-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">TOTAL INGRESOS</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}" alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-bill-200">{{$data['incomes']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}" alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-bill-100">{{$data['incomes']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}" alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-bill-50">{{$data['incomes']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}" alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-bill-20">{{$data['incomes']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}" alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-bill-10">{{$data['incomes']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-5">{{$data['incomes']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-2">{{$data['incomes']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-1">{{$data['incomes']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-0-5">{{$data['incomes']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-0-2">{{$data['incomes']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-coin-0-1">{{$data['incomes']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['incomes']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex py-1 font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="incomes-balance-total">{{$data['incomes']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-expenses-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">TOTAL EGRESOS</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}" alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-bill-200">{{$data['expenses']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}" alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-bill-100">{{$data['expenses']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}" alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-bill-50">{{$data['expenses']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}" alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-bill-20">{{$data['expenses']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}" alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-bill-10">{{$data['expenses']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-5">{{$data['expenses']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-2">{{$data['expenses']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-1">{{$data['expenses']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-0-5">{{$data['expenses']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-0-2">{{$data['expenses']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-coin-0-1">{{$data['expenses']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['expenses']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex py-1 font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="expenses-balance-total">{{$data['expenses']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-physical-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">TOTAL FÍSICO</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}"
                                                 alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-bill-200">{{$data['physical']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}"
                                                 alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-bill-100">{{$data['physical']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}"
                                                 alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-bill-50">{{$data['physical']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}"
                                                 alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-bill-20">{{$data['physical']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}"
                                                 alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-bill-10">{{$data['physical']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-5">{{$data['physical']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-2">{{$data['physical']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-1">{{$data['physical']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-0-5">{{$data['physical']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-0-2">{{$data['physical']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-coin-0-1">{{$data['physical']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['physical']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex py-1 font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="physical-balance-total">{{$data['physical']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-closing-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">TOTAL DIGITAL</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}"
                                                 alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-bill-200">{{$data['closing']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}"
                                                 alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-bill-100">{{$data['closing']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}"
                                                 alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-bill-50">{{$data['closing']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}"
                                                 alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-bill-20">{{$data['closing']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}"
                                                 alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-bill-10">{{$data['closing']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-5">{{$data['closing']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-2">{{$data['closing']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-1">{{$data['closing']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-0-5">{{$data['closing']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-0-2">{{$data['closing']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-coin-0-1">{{$data['closing']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['closing']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex py-1 font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="closing-balance-total">{{$data['closing']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pb-8 md:pb-0"
                                 id="show-difference-modal">
                                <p class="font-bold py-1 text-sm text-center py-4">DIFERENCIA</p>
                                <hr class="py-2">
                                <div class="divide-y divide-[#f3f4f6]">
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/200.ico') }}"
                                                 alt="Billete de 200 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-bill-200">{{$data['difference']['bill_200']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['bill_200']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/100.ico') }}"
                                                 alt="Billete de 100 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-bill-100">{{$data['difference']['bill_100']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['bill_100']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/50.ico') }}"
                                                 alt="Billete de 50 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-bill-50">{{$data['difference']['bill_50']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['bill_50']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/20.ico') }}"
                                                 alt="Billete de 20 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-bill-20">{{$data['difference']['bill_20']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['bill_20']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/10.ico') }}"
                                                 alt="Billete de 10 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-bill-10">{{$data['difference']['bill_10']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['bill_10']==1?'Billete':'Billetes'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-5">{{$data['difference']['coin_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-2">{{$data['difference']['coin_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-1">{{$data['difference']['coin_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-0-5">{{$data['difference']['coin_0_5']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_0_5']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-0-2">{{$data['difference']['coin_0_2']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_0_2']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div class="flex py-1">
                                        <p class="flex flex-1 justify-end items-center pr-4">
                                            <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
                                        </p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-coin-0-1">{{$data['difference']['coin_0_1']}}&nbsp;
                                            <span
                                                class="text-sm text-gray-500">{{$data['difference']['coin_0_1']==1?'Moneda':'Monedas'}}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="flex py-1 font-extrabold pt-4">
                                        <p class="flex flex-1 justify-end items-center pr-4">Bs&nbsp;&nbsp; Total</p>
                                        <div class="flex flex-1 justify-start items-center pl-4"
                                             id="difference-balance-total">{{$data['difference']['physical_cash']}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-center text-gray-800 rounded-lg shadow-md">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636L5.636 18.364M6 6h.01M6 6h12m0 0v12m0 0H6m0 0v-12m0 0H6M5.636 5.636l12.728 12.728"/>
                            </svg>
                            <p class="text-lg font-semibold">No tienes una sesión de caja abierta</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Por favor, solicite una nueva sesión de caja para continuar con tus operaciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 text-white rounded-lg shadow-md">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if(auth()->user()->hasRole('Administrador'))
                            <a href="{{ route('cashregisters.index') }}"
                               :active="request()->routeIs('cashregisters.index')"
                               class="bg-gradient-to-r from-[#5C4033] via-[#8C6446] to-[#ddb082] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_cashregister') }}</div>
                                    <div class="text-4xl"><i class="bi bi-box"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_cashregisters}} {{ __('word.cashregister.title') }}</p>
                                <div class="mt-4 h-1 bg-green-200 rounded-full">
                                    <div class="w-2/3 h-full bg-green-600"></div>
                                </div>
                            </a>
                        @endif
                        @if(auth()->user()->hasRole('Administrador'))
                            <a href="{{ route('cashflowdailies.index') }}"
                               :active="request()->routeIs('cashflowdailies.index')"
                               class="bg-gradient-to-r from-slate-700 via-slate-500 to-slate-300 text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_cashflowdaily') }}</div>
                                    <div class="text-4xl"><i class="bi bi-graph-up-arrow"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_cashflowdailies}} {{ __('word.cashflowdaily.title') }}</p>
                                <div class="mt-4 h-1 bg-green-200 rounded-full">
                                    <div class="w-2/3 h-full bg-green-600"></div>
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('cashshifts.index') }}" :active="request()->routeIs('cashshifts.index')"
                           class="bg-gradient-to-r from-[#F9A602] via-[#F9D835] to-[#FFED85] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{ __('word.general.total_cashshift') }}</div>
                                <div class="text-4xl"><i class="bi bi-person-circle"></i></div>
                            </div>
                            <p class="mt-2 text-lg">
                                @if(auth()->user()->hasRole('Administrador'))
                                    {{$total_cashshifts}}
                                @else
                                    {{$total_cashshifts_by_user}}
                                @endif
                                {{ __('word.cashshift.title') }}</p>
                            <div class="mt-4 h-1 bg-yellow-200 rounded-full">
                                <div class="w-1/2 h-full bg-yellow-600"></div>
                            </div>
                        </a>
                        <a href="{{ route('paymentwithprices.index') }}"
                           :active="request()->routeIs('paymentwithprices.index')"
                           class="bg-gradient-to-r from-[#6A0572] via-[#AB47BC] to-[#E1BEE7] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{__('word.general.total_transaction')}}</div>
                                <div class="text-4xl"><i class="bi bi-receipt"></i></div>
                            </div>
                            <p class="mt-2 text-lg">
                                @if(auth()->user()->hasRole('Administrador'))
                                    {{$total_payments}}
                                @else
                                    {{$total_payments_by_user}}
                                @endif
                                {{__('word.payment.panel')}}</p>
                            <div class="mt-4 h-1 bg-pink-200 rounded-full">
                                <div class="w-5/6 h-full bg-pink-600"></div>
                            </div>
                        </a>
                        <a href="{{ route('sales.index') }}" :active="request()->routeIs('sales.index')"
                           class="bg-gradient-to-r from-[#A8E063] via-[#58D68D] to-[#2ECC71] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{ __('word.general.total_sales') }}</div>
                                <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                            </div>
                            <p class="mt-2 text-lg">
                                @if(auth()->user()->hasRole('Administrador'))
                                    {{$total_sales}}
                                @else
                                    {{$total_sales_by_user}}
                                @endif
                                {{ __('word.sale.title') }}</p>
                            <div class="mt-4 h-1 bg-red-200 rounded-full">
                                <div class="w-3/4 h-full bg-red-600"></div>
                            </div>
                        </a>
                        <a href="{{ route('expenses.index') }}" :active="request()->routeIs('expenses.index')"
                           class="bg-gradient-to-r from-[#C92A2A] via-[#E63946] to-[#f79f96] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{ __('word.general.total_expenses') }}</div>
                                <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                            </div>
                            <p class="mt-2 text-lg">
                                @if(auth()->user()->hasRole('Administrador'))
                                    {{$total_expenses}}
                                @else
                                    {{$total_expenses_by_user}}
                                @endif
                                {{ __('word.expense.title') }}</p>
                            <div class="mt-4 h-1 bg-red-200 rounded-full">
                                <div class="w-3/4 h-full bg-red-600"></div>
                            </div>
                        </a>
                        @if(auth()->user()->hasRole('Administrador'))
                            <a href="{{ route('users.index') }}" :active="request()->routeIs('users.index')"
                               class="bg-gradient-to-r from-[#FF7EB3] via-[#FF758C] to-[#FEB47B] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-semibold">{{__('word.general.total_user')}}</div>
                                    <div class="text-4xl"><i class="bi bi-file-earmark-person"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_users}} {{__('word.user.title')}}</p>
                                <div class="mt-4 h-1 bg-green-200 rounded-full">
                                    <div class="w-2/3 h-full bg-green-600"></div>
                                </div>
                            </a>
                            <a href="{{ route('categories.index') }}"
                               :active="request()->routeIs('categories.index')"
                               class="bg-gradient-to-r from-[#6A11CB] via-[#2575FC] to-[#a1c3fb] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-semibold">{{__('word.general.total_category')}}</div>
                                    <div class="text-4xl"><i class="bi bi-folder"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_categories}} {{__('word.category.title')}}</p>
                                <div class="mt-4 h-1 bg-blue-200 rounded-full">
                                    <div class="w-3/4 h-full bg-blue-600"></div>
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('serviceswithoutprices.index') }}"
                           :active="request()->routeIs('serviceswithoutprices.index')"
                           class="bg-gradient-to-r from-[#0F9B0F] via-[#00B09B] to-[#96FBC4] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{__('word.general.total_service')}}</div>
                                <div class="text-4xl"><i class="bi bi-grid"></i></div>
                            </div>
                            <p class="mt-2 text-lg">{{$total_services}} {{__('word.service.title')}}</p>
                            <div class="mt-4 h-1 bg-pink-200 rounded-full">
                                <div class="w-5/6 h-full bg-pink-600"></div>
                            </div>
                        </a>
                        <a href="{{ route('products.index') }}"
                           :active="request()->routeIs('products.index')"
                           class="bg-gradient-to-r from-[#3B82F6] via-[#9333EA] to-[#E879F9] text-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-semibold">{{__('word.general.total_products')}}</div>
                                <div class="text-4xl"><i class="bi bi-grid"></i></div>
                            </div>
                            <p class="mt-2 text-lg">{{$total_products}} {{__('word.product.title')}}</p>
                            <div class="mt-4 h-1 bg-pink-200 rounded-full">
                                <div class="w-5/6 h-full bg-pink-600"></div>
                            </div>
                        </a>
                        @if(auth()->user()->hasRole('Administrador'))
                            <a href="{{ route('transactionmethods.index') }}"
                               :active="request()->routeIs('transactionmethods.index')"
                               class="bg-gradient-to-r from-[#078aad] via-[#2da3c3] to-[#65d5f3] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div class="text-2xl font-semibold">{{__('word.general.total_method')}}</div>
                                    <div class="text-4xl"><i class="bi bi-cash"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_transactionmethods}} {{__('word.transactionmethod.title')}}</p>
                                <div class="mt-4 h-1 bg-pink-200 rounded-full">
                                    <div class="w-5/6 h-full bg-pink-600"></div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
