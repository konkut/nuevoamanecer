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
        <link rel="stylesheet" href="{{ url('css/components/date.css?v='.time()) }}">
        <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_session_panel.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/dashboard/fetch_date_panel.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex justify-end flex-1 items-center">
                <label for="date" class="hidden sm:flex text-md font-medium">{{__('word.panel.title')}}:</label>
                <input
                    type="date"
                    name="date"
                    id="date"
                    value="{{ session('date', now()->format('Y-m-d')) }}"
                    class="ml-8 border border-blue-500 rounded-md px-3 py-2 text-gray-700 bg-blue-500 text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    onchange="fetch_date(this, '{{url('/')}}', event)">
                <a id="session-date"
                   href="{{ route('dashboards.search_sessions') }}"
                   style="display: none;">
                </a>
            </div>
        </div>

    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    @if (session('error'))
        <x-alert-error :message="session('error')"/>
    @endif
    <div class="block w-full px:0 sm:px-8 bg-blue-500 text-white {{$cashshifts->isEmpty() ? 'pb-8':''}}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8 w-full">
            <x-panel-box-link
                :total="$total_cashshifts"
                :route="route('cashshifts.index')"
                title="{{__('word.general.total_cashshift')}}"
                subtitle="{{__('word.cashshift.title')}}"
            ></x-panel-box-link>
            <x-panel-box-link
                :total="$total_incomes"
                :route="route('incomes.index')"
                title="{{__('word.general.total_transaction')}}"
                subtitle="{{__('word.income.title')}}"
            ></x-panel-box-link>
            <x-panel-box-link
                :total="$total_expenses"
                :route="route('expenses.index')"
                title="{{__('word.general.total_expenses')}}"
                subtitle="{{__('word.expense.title')}}"
            ></x-panel-box-link>
            <x-panel-box-link
                :total="$total_sales"
                :route="route('sales.index')"
                title="{{__('word.general.total_sales')}}"
                subtitle="{{__('word.sale.title')}}"
            ></x-panel-box-link>
            <x-panel-box-link
                :total="$total_vouchers"
                :route="route('vouchers.index')"
                title="{{__('word.general.total_voucher')}}"
                subtitle="{{__('word.voucher.title')}}"
            ></x-panel-box-link>
        </div>
        @if(!$cashshifts->isEmpty())
            <div class="pb-8 w-full">
                <x-panel-box-all-sessions :cashshifts="$cashshifts"></x-panel-box-all-sessions>
            </div>
        @endif
    </div>
    <div class="flex flex-row flex-wrap">
        <div class="flex flex-col flex-wrap flex-1">
            <div class="flex-1 sm:px-6 lg:px-8 py-8">
                <div class="text-gray-800 flex flex-row flex-wrap flex-1" id="dashboard-summary">
                    <x-panel-chart :cash="$chart_cash_sessions"
                                   :bank="$chart_bank_sessions"
                                   :platform="$chart_platform_sessions"
                    ></x-panel-chart>
                    {{-- <x-panel-box-all-summary :data="$data_sessions"></x-panel-box-all-summary>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
