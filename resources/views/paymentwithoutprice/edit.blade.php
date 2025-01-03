<x-app-layout>
    <x-slot name="title">
        {{ __('word.payment.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.payment.meta.edit.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.payment.meta.edit.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.payment.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.payment.meta.edit.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/payment/ticketing_payment_without_price.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/total_and_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.payment.resource.edit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST"
                      action="{{route('paymentwithoutprices.update', $paymentwithoutprice->paymentwithoutprice_uuid)}}">
                    @csrf
                    @method("PUT" )
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="w-full">
                            <x-form-paymentwithoutprice :paymentwithoutprice="$paymentwithoutprice"
                                                        :transactionmethods="$transactionmethods"
                                                        :servicewithprices="$servicewithprices"
                                                        :quantities="$quantities"
                                                             :services="$services"
                                                             :methods="$methods"/>
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
                            <x-form-billcoin :denomination="$denomination" :digital="true" :title="'INGRESO FÍSICO'"></x-form-billcoin>
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
