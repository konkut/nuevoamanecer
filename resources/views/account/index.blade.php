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
        <script type="text/javascript" src="{{ asset('/js/account/fetch_edit_account.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('word.account.link') }}
        </h2>
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
                    {{ __('word.account.title') }}
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
                @include('account.account')
            </div>
        </div>
    </div>
</x-app-layout>
