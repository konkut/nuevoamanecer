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
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_one_sesion_panel.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="flex flex-row flex-wrap">
        <div class="w-full xl:w-80 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg mt-8">
                <div class="p-6 text-gray-800">
                    <div class="text-center mb-6">
                        <h2 class="text-md font-bold text-gray-700">Medios de Transacción</h2>
                        <p class="text-sm text-gray-500">Estado general de saldos en el sistema</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Medio
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Saldo
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($methods as $item)
                                @if($item->name !== "EFECTIVO")
                                    <tr>
                                        <td class="px-3 py-2 text-xs text-gray-700">{{ $item->name }}</td>
                                        <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->balance }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-xl rounded-lg mt-8">
                <div class="p-6 text-gray-800">
                    <div class="text-center mb-6">
                        <h2 class="text-md font-bold text-gray-700">Inventario Total de Productos</h2>
                        <p class="text-sm text-gray-500">Estado general del stock en el sistema</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Precio
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products_and_quantities as $item)
                                <tr>
                                    <td class="px-3 py-2 text-xs text-gray-700">{{ $item->name }}</td>
                                    <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->stock }}</td>
                                    <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($cashshift)
            <div class="w-full xl:w-72 sm:px-6 lg:px-0 pt-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                     onclick="fetch_one_sesion(event, '{{ $cashshift->cashshift_uuid }}',this)">
                    <div class="flex p-6 text-center text-gray-800 rounded-lg shadow-md flex-wrap">
                        <div class="flex-1 flex-col items-center justify-center">
                            <p class="text-sm font-extrabold text-gray-700 mb-2">Estado de la Sesión de Caja</p>
                            <div class="mb-2"><span id="toggleStatus"
                                                    class="mr-2 text-sm text-gray-700 {{ $cashshift->status ? 'text-green-500' : 'text-red-500' }}">{{ $cashshift->status ? 'Habilitado' : 'Deshabilitado' }}</span>
                                <form action="{{route('dashboards.state',$cashshift->cashshift_uuid)}}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" id="toggleButton"
                                            class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $cashshift->status ? 'bg-green-500' : 'bg-red-500' }}"
                                            onclick="toggleStatus()">
                                        <div
                                            class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $cashshift->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                                    </button>
                                    <input type="hidden" name="status" id="status"
                                           value="{{ $cashshift->status ? '1' : '0' }}">
                                </form>
                            </div>
                            <p class="text-sm text-gray-500">Detalles de la sesión actual</p>
                            <div
                                class="flex-1 rounded-lg p-4 text-center text-xs text-gray-600 space-y-3">
                                <p><span
                                        class="font-semibold text-gray-700">Caja asignada:</span> {{$cashregister_name}}
                                </p>
                                <p><span
                                        class="font-semibold text-gray-700">Responsable:</span> {{$cashshift->user->name}}
                                </p>
                                <p><span
                                        class="font-semibold text-gray-700 py-2">Hora de apertura:<br> </span> {{$cashshift->start_time}}
                                </p>
                                <p><span
                                        class="font-semibold text-gray-700 py-2">Hora de cierre:<br></span> {{$cashshift->end_time??'Pendiente'}}
                                </p>
                                @if($cashshift->observation)
                                    <p><span
                                            class="font-semibold text-gray-700">Observaciones:</span> {{$cashshift->observation}}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a id="state-session-form-{{ $cashshift->cashshift_uuid }}"
                   href="{{ route('dashboards.sesion', $cashshift->cashshift_uuid) }}"
                   style="display: none;">
                </a>
            </div>
        @else
            <div class="w-full xl:w-72 sm:px-6 lg:px-0 pt-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-center text-gray-800 rounded-lg shadow-md">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"
                                        fill="none"/>
                                <circle cx="9" cy="10" r="1" fill="currentColor"/>
                                <circle cx="15" cy="10" r="1" fill="currentColor"/>
                                <path d="M8 14c1.5 2 4.5 2 6 0" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-lg font-semibold">No tienes una sesión de caja activa</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Por favor, solicita la activación de una nueva sesión de caja para continuar con
                                tus
                                operaciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="flex flex-col flex-wrap flex-1">
            <div class="flex-1 sm:px-6 lg:px-8 py-8" id="dashboard-content">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 text-white rounded-lg shadow-md">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
                            <a href="{{ route('cashshifts.index') }}"
                               :active="request()->routeIs('cashshifts.index')"
                               class="bg-gradient-to-r from-[#F9A602] via-[#F9D835] to-[#FFED85] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_cashshift') }}</div>
                                    <div class="text-4xl"><i class="bi bi-person-circle"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_cashshifts_by_user}} {{ __('word.cashshift.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('incomes.index') }}"
                               :active="request()->routeIs('incomes.index')"
                               class="bg-gradient-to-r from-[#6A0572] via-[#AB47BC] to-[#E1BEE7] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_transaction')}}</div>
                                    <div class="text-4xl"><i class="bi bi-receipt"></i></div>
                                </div>
                                <p class="mt-2 text-lg"> {{$total_incomes_by_user}}  {{__('word.income.title')}}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('sales.index') }}" :active="request()->routeIs('sales.index')"
                               class="bg-gradient-to-r from-[#A8E063] via-[#58D68D] to-[#2ECC71] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_sales') }}</div>
                                    <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_sales_by_user}} {{ __('word.sale.title') }}</p>
                                <div class="mt-4 h-1 bg-red-200 rounded-full">
                                    <div class="w-3/4 h-full bg-red-600"></div>
                                </div>
                            </a>
                            <a href="{{ route('expenses.index') }}"
                               :active="request()->routeIs('expenses.index')"
                               class="bg-gradient-to-r from-[#C92A2A] via-[#E63946] to-[#f79f96] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_expenses') }}</div>
                                    <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                                </div>
                                <p class="mt-2 text-lg"> {{$total_expenses_by_user}} {{ __('word.expense.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('services.index') }}"
                               :active="request()->routeIs('services.index')"
                               class="bg-gradient-to-r from-[#0F9B0F] via-[#00B09B] to-[#96FBC4] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_service')}}</div>
                                    <div class="text-4xl"><i class="bi bi-grid"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_services}} {{__('word.service.title')}}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('products.index') }}"
                               :active="request()->routeIs('products.index')"
                               class="bg-gradient-to-r from-[#3B82F6] via-[#9333EA] to-[#E879F9] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_products')}}</div>
                                    <div class="text-4xl"><i class="bi bi-grid"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_products}} {{__('word.product.title')}}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
