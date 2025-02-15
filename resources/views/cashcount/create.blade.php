<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashshift.meta.create_cashcount.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashshift.meta.create_cashcount.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashshift.meta.create_cashcount.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashshift.meta.create_cashcount.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashshift.meta.create_cashcount.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/cashcount/clear_billcoin.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashcount/operation_billcoin.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.cashshift.resource.create_physical') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST" action="{{ route('cashcounts.store',$cashshift_uuid)  }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="w-full md:col-span-1">
                            <h1 class="text-md font-bold italic block text-center">{{__('word.cashshift.box_billcoin')}}</h1>
                            <x-form-cashcount-enable :token="$cashshift_uuid" :denomination="$cashcount" :operation="$operation_cashcount" form="cashcount"></x-form-cashcount-enable>
                        </div>
                        <div class="w-full md:col-span-1 mt-4 md:mt-0">
                            <h1 class="text-md font-bold italic block text-center">{{__('word.cashshift.box_closing')}}</h1>
                            <x-form-cashcount-disable :token="$cashshift_uuid" :denomination="$closing" :operation="$operation_closing" form="closing"></x-form-cashcount-disable>
                        </div>
                        <div class="w-full md:col-span-1 mt-4 md:mt-0">
                            <h1 class="text-md font-bold italic block text-center">{{__('word.cashshift.box_difference')}}</h1>
                            <x-form-cashcount-disable :token="$cashshift_uuid" :denomination="$difference" :operation="$operation_difference" form="difference"></x-form-cashcount-disable>
                        </div>
                        <div class="w-full md:col-span-3">
                            @if ($errors->any())
                                <div class=" mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
                                     role="alert">
                                    <strong class="font-bold">{{__('word.general.validation')}}</strong>
                                    <ul class="mt-2 ml-4 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mt-4 flex justify-end gap-8">
                                <div class="sm:flex items-center justify-center">
                                    <a href="#" onclick="clear_billcoin_cashcount('{{$cashshift_uuid}}')" title="Limpiar campos"
                                       class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3"
                                             viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                        </svg>
                                    </a>
                                </div>
                                <x-button>
                                    {{ __('Save') }}
                                </x-button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

