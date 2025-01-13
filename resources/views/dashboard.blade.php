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
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_all_sesions_panel.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_one_sesion_panel.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            {{--
            <div class="flex justify-end flex-1 items-center">
                <x-label for="observation" value="Arqueo del día: "/>
                <form action="{{ route('dashboards.search') }}" method="GET" id="dateForm">
                    @csrf
                    <input
                        type="date"
                        name="date"
                        class="ml-8 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-gray-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="document.getElementById('dateForm').submit()">
                </form>
            </div>
            --}}
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
                        <h2 class="text-lg font-bold text-gray-700">Control de Operaciones</h2>
                        <p class="text-sm text-gray-500">Información adicional sobre las operaciones</p>
                    </div>
                    <div class="overflow-x-auto">
                        <a href="{{ route('control') }}" class="flex justify-center items-center bg-gray-200 text-dark text-sm font-medium py-2  rounded-lg hover:bg-gray-300 transition duration-200">
                            <i class="bi bi-gear-fill mr-2"></i>
                            Ver detalles
                        </a>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-xl rounded-lg mt-8">
                <div class="p-6 text-gray-800">
                    <div class="text-center mb-6">
                        <h2 class="text-lg font-bold text-gray-700">Cuentas bancarias</h2>
                        <p class="text-sm text-gray-500">Estado general de saldos de cuentas en el sistema</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Cuenta
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Débito
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Crédito
                                </th>
                                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            {{--@foreach($methods as $item)
                                @if($item->name !== "EFECTIVO")
                                    <tr>
                                        <td class="px-3 py-2 text-xs text-gray-700">{{ $item->name }}</td>
                                        <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->balance }}</td>
                                    </tr>
                                @endif
                            @endforeach--}}
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
        @if(!$cashshifts->isEmpty())
            <div class="w-full xl:w-72 sm:px-6 lg:px-0" id="cards-container">
                <div
                    class="bg-white block overflow-hidden shadow-xl sm:rounded-lg mt-8 cursor-pointer hover:shadow-2xl transition-shadow duration-300"
                    onclick="fetch_all_sesions(event,this)">
                    <div class="flex items-center justify-center p-6 gap-4 text-center text-gray-800 rounded-lg">
                        <div
                            class="flex items-center justify-center bg-blue-100 text-blue-500 w-12 h-12 rounded-full shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 9l3 3-3 3m4-6l3 3-3 3M2 12h20"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700">Ver todas las sesiones</p>
                            <p class="text-xs text-gray-500">Haz clic para explorar el historial completo de sesiones
                                activas.</p>
                        </div>
                    </div>
                </div>
                <a id="state-sessions-form"
                   href="{{ route('dashboards.sesions') }}"
                   style="display: none;">
                </a>
                @foreach($cashshifts as $cashshift)
                    <div
                        onclick="fetch_one_sesion(event, '{{ $cashshift->cashshift_uuid }}',this)"
                        class="block bg-white mt-8 flex-col overflow-hidden shadow-xl sm:rounded-lg cursor-pointer">
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
                @endforeach
            </div>
        @else
            <div class="w-full xl:w-72 sm:px-6 lg:px-0 pt-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 text-center text-gray-800 rounded-lg shadow-md">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500 mb-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="9" cy="10" r="1" fill="currentColor"/>
                                <circle cx="15" cy="10" r="1" fill="currentColor"/>
                                <path d="M8 14c1.5 2 4.5 2 6 0" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="text-lg font-semibold">No hay sesiones de caja activas</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Por favor, registre una nueva sesión de caja para habilitar las operaciones del
                                sistema.
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
                            <a href="{{ route('cashregisters.index') }}"
                               :active="request()->routeIs('cashregisters.index')"
                               class="bg-gradient-to-r from-[#5C4033] via-[#8C6446] to-[#ddb082] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_cashregister') }}</div>
                                    <div class="text-4xl"><i class="bi bi-box"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_cashregisters}} {{ __('word.cashregister.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('bankregisters.index') }}"
                               :active="request()->routeIs('bankregisters.index')"
                               class="bg-gradient-to-r from-[#D97941] via-[#F0A865] to-[#FDD5A5] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_bankregister') }}</div>
                                    <div class="text-4xl"><i class="bi-cash-stack"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_bankregisters}} {{ __('word.bankregister.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            {{--
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
                            --}}
                            <a href="{{ route('cashshifts.index') }}"
                               :active="request()->routeIs('cashshifts.index')"
                               class="bg-gradient-to-r from-[#F9A602] via-[#F9D835] to-[#FFED85] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{ __('word.general.total_cashshift') }}</div>
                                    <div class="text-4xl"><i class="bi bi-person-circle"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_cashshifts}} {{ __('word.cashshift.title') }}</p>
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
                                <p class="mt-2 text-lg">{{$total_incomes}} {{__('word.income.title')}}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('sales.index') }}"
                               :active="request()->routeIs('sales.index')"
                               class="bg-gradient-to-r from-[#A8E063] via-[#58D68D] to-[#2ECC71] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold"> {{ __('word.general.total_sales') }}</div>
                                    <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                                </div>
                                <p class="mt-2 text-lg"> {{$total_sales}} {{ __('word.sale.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('expenses.index') }}"
                               :active="request()->routeIs('expenses.index')"
                               class="bg-gradient-to-r from-[#C92A2A] via-[#E63946] to-[#f79f96] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold"> {{ __('word.general.total_expenses') }}</div>
                                    <div class="text-4xl"><i class="bi bi-cash-stack"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_expenses}} {{ __('word.expense.title') }}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('users.index') }}"
                               :active="request()->routeIs('users.index')"
                               class="bg-gradient-to-r from-[#FF7EB3] via-[#FF758C] to-[#FEB47B] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_user')}}</div>
                                    <div class="text-4xl"><i class="bi bi-file-earmark-person"></i>
                                    </div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_users}} {{__('word.user.title')}}</p>
                                <div class="mt-4 h-1 bg-gray-200 rounded-full">
                                    <div class="w-2/3 h-full bg-gray-400"></div>
                                </div>
                            </a>
                            <a href="{{ route('categories.index') }}"
                               :active="request()->routeIs('categories.index')"
                               class="bg-gradient-to-r from-[#6A11CB] via-[#2575FC] to-[#a1c3fb] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_category')}}</div>
                                    <div class="text-4xl"><i class="bi bi-folder"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_categories}} {{__('word.category.title')}}</p>
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
                            <a href="{{ route('methods.index') }}"
                               :active="request()->routeIs('methods.index')"
                               class="bg-gradient-to-r from-[#078aad] via-[#2da3c3] to-[#65d5f3] text-white p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="text-2xl font-semibold">{{__('word.general.total_method')}}</div>
                                    <div class="text-4xl"><i class="bi bi-cash"></i></div>
                                </div>
                                <p class="mt-2 text-lg">{{$total_methods}} {{__('word.method.title')}}</p>
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
