<x-app-layout>
    <x-slot name="title">
        {{ __('word.cashshift.meta.create.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.cashshift.meta.create.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.cashshift.meta.create.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.cashshift.meta.create.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.cashshift.meta.create.description')}}
    </x-slot>


    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/cashshift/ticketing_physical.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/total_and_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.cashshift.resource.create_physical') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST" action="{{ route('cashshifts.store_physical',$cashshift_uuid)  }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-form-cashcount :cashshift="$cashshift"></x-form-cashcount>
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
                            <x-form-billcoin :denomination="$denomination" :digital="false" :title="'BILLETAJE'"></x-form-billcoin>
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

