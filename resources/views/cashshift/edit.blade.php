<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashshift.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashshift.meta.edit.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashshift.meta.edit.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashshift.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashshift.meta.edit.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/ticketing.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/fetch_cash_register.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/fetch_bank_register.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/total_and_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.cashshift.resource.edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST"
                      action="{{route('cashshifts.update', $cashshift->cashshift_uuid)}}">
                    @csrf
                    @method("PUT" )
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="w-full">
                            <h1 class="text-md font-bold italic block text-center py-8">{{__('word.cashshift.box_session')}}</h1>
                            <x-form-cashshift
                                :cashshift="$cashshift"
                                :cashregisters="$cashregisters"
                                :bankregisters="$bankregisters"
                                :users="$users"
                                :allfields="false"></x-form-cashshift>
                            <div class="mt-4">
                                <x-label for="status" value="{{ __('word.cashshift.attribute.status') }}"/>
                                <div class="relative flex items-center"><span id="toggleStatus" class="mr-2 text-gray-700 {{ $cashshift->status ? 'text-green-500' : 'text-red-500' }}">{{ $cashshift->status ? 'On' : 'Off' }}</span>
                                    <button type="button" id="toggleButton"
                                            class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $cashshift->status ? 'bg-green-500' : 'bg-red-500' }}"
                                            onclick="toggleStatus()">
                                        <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $cashshift->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                                    </button>
                                    <input type="hidden" name="status" id="status"
                                           value="{{ $cashshift->status ? '1' : '0' }}">
                                </div>
                            </div>
                            @if ($errors->any())
                                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
                                     role="alert">
                                    <strong class="font-bold">¡Ups! Algo salió mal:</strong>
                                    <ul class="mt-2 ml-4 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="w-full">
                            <div class="mt-4 flex justify-end">
                                <x-button>
                                    {{ __('Save') }}
                                </x-button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
