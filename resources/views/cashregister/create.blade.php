<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashregister.meta.create.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashregister.meta.create.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashregister.meta.create.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashregister.meta.create.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashregister.meta.create.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/cashregister/total_billcoin.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.cashregister.resource.create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST" action="{{ route('cashregisters.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="w-full">
                            <h1 class="text-md font-bold italic block text-center py-8">{{__('word.cashregister.box_register')}}</h1>
                            <x-form-cashregister :cashregister="$cashregister"
                            ></x-form-cashregister>
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
                            <h1 class="text-md font-bold italic block text-center py-8">{{__('word.denomination.billcoin')}}</h1>
                            <x-form-billcoin :denomination="$denomination" :digital="false"
                                             :balance="false"></x-form-billcoin>
                            <div class="mt-4 flex justify-end">
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

