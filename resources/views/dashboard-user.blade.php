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
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_session_panel.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_date_panel.js?v='.time()) }}"></script>
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
    @if (session('error'))
        <x-alert-error :message="session('error')"/>
    @endif
    <div class="flex flex-row flex-wrap">
        {{--
        <div class="w-full xl:w-80 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg mt-8">
                <x-panel-box-inventory :inventory="$inventory"></x-panel-box-inventory>
            </div>
        </div>--}}
        @if($cashshift)
            <div class="w-full xl:w-72 sm:px-6 lg:px-8 xl:ps-0 xl:ms-8" id="dashboard-session">
                <x-panel-box-all-session :cashshift="$cashshift"></x-panel-box-all-session>
            </div>
        @else
            <div class="w-full xl:w-72 sm:px-6 lg:px-8 xl:px-0 xl:ms-8" id="dashboard-session">
                <x-panel-box-off-session></x-panel-box-off-session>
            </div>
        @endif
        <div class="flex flex-col flex-wrap flex-1">
            <div class="flex-1 sm:px-6 lg:px-8 py-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 rounded-lg shadow-md">
                        <div class="flex justify-end flex-1 items-center">
                            <x-label for="date" value="Resumen Financiero del Día "/>
                            <input
                                type="date"
                                name="date"
                                id="date"
                                value="{{ session('date', now()->format('Y-m-d')) }}"
                                class="ml-8 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-gray-700 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="fetch_date(event,this)">
                            <a id="session-date"
                               href="{{ route('dashboards.search_session') }}"
                               style="display: none;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-gray-800 mt-8 flex flex-row flex-wrap flex-1 gap-8 "
                     id="dashboard-summary">
                    {{--
                       <x-panel-box-link :totalcashregisters="null"
                                          :totalbankregisters="null"
                                          :totalcashshifts="null"
                                          :totalcashshiftsbyuser="$total_cashshifts_by_user"
                                          :totalincomes="null"
                                          :totalincomesbyuser="$total_incomes_by_user"
                                          :totalsales="null"
                                          :totalsalesbyuser="$total_sales_by_user"
                                          :totalexpenses="null"
                                          :totalexpensesbyuser="$total_expenses_by_user"
                                          :totalusers="null"
                                          :totalcategories="null"
                                          :totalservices="$total_services"
                                          :totalproducts="$total_products"
                                          :totalmethods="null"
                        ></x-panel-box-link>
                       --}}
                    <x-panel-box-all-summary :data="$data_session"></x-panel-box-all-summary>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

