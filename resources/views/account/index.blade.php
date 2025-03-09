<x-app-layout>
    <x-slot name="title">
        {{ __('word.account.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.account.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.account.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.account.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.account.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/show_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/enable_and_disable_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/create_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/edit_modal.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/fetch_delete.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_accountclass.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_accountgroup.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_accountsubgroup.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_mainaccount.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_analyticalaccount.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">{{ __('word.account.link') }}</h2>
            <a href="{{route('accounts.chart')}}"
               class="bg-pink-400 text-white px-4 py-2 rounded text-sm"
               title="{{__('word.general.title_icon_chart')}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                </svg>
            </a>
        </div>
    </x-slot>
    @if (session('success'))
        <x-alert :message="session('success')"/>
    @endif
    <div class="py-12" x-data="{ activeTab: localStorage.getItem('activeTab') || 'tab1' }"
         x-init="$watch('activeTab', value => localStorage.setItem('activeTab', value))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex border-b-2 border-gray-300 mb-4 space-x-4 overflow-x-auto">
                <button @click="activeTab = 'tab1'"
                        :class="activeTab === 'tab1' ? 'border-b-4 border-blue-400 text-blue-400 font-semibold' : 'text-gray-600 hover:text-blue-500'"
                        class="px-6 py-2 transition-all duration-300">
                    {{ __('word.accountclass.title') }}
                </button>

                <button @click="activeTab = 'tab2'"
                        :class="activeTab === 'tab2' ? 'border-b-4 border-blue-400 text-blue-400 font-semibold' : 'text-gray-600 hover:text-blue-500'"
                        class="px-6 py-2 transition-all duration-300">
                    {{ __('word.accountgroup.title') }}
                </button>

                <button @click="activeTab = 'tab3'"
                        :class="activeTab === 'tab3' ? 'border-b-4 border-blue-400 text-blue-400 font-semibold' : 'text-gray-600 hover:text-blue-500'"
                        class="px-6 py-2 transition-all duration-300">
                    {{ __('word.accountsubgroup.title') }}
                </button>

                <button @click="activeTab = 'tab4'"
                        :class="activeTab === 'tab4' ? 'border-b-4 border-blue-400 text-blue-400 font-semibold' : 'text-gray-600 hover:text-blue-500'"
                        class="px-6 py-2 transition-all duration-300">
                    {{ __('word.mainaccount.title') }}
                </button>

                <button @click="activeTab = 'tab5'"
                        :class="activeTab === 'tab5' ? 'border-b-4 border-blue-400 text-blue-400 font-semibold' : 'text-gray-600 hover:text-blue-500'"
                        class="px-6 py-2 transition-all duration-300">
                    {{ __('word.analyticalaccount.title') }}
                </button>
            </div>
            <div x-show="activeTab === 'tab1'" x-cloak class="overflow-hidden shadow-xl sm:rounded-lg">
                @include('account.accountclass')
            </div>
            <div x-show="activeTab === 'tab2'" x-cloak class="overflow-hidden shadow-xl sm:rounded-lg">
                @include('account.accountgroup')
            </div>
            <div x-show="activeTab === 'tab3'" x-cloak class="overflow-hidden shadow-xl sm:rounded-lg">
                @include('account.accountsubgroup')
            </div>
            <div x-show="activeTab === 'tab4'" x-cloak class="overflow-hidden shadow-xl sm:rounded-lg">
                @include('account.mainaccount')
            </div>
            <div x-show="activeTab === 'tab5'" x-cloak class="overflow-hidden shadow-xl sm:rounded-lg">
                @include('account.analyticalaccount')
            </div>
        </div>
    </div>
</x-app-layout>
