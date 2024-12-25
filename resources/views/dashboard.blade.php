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

    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
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
                            <a href="{{ route('categories.index') }}" :active="request()->routeIs('categories.index')"
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
