<x-app-layout>
    <x-slot name="title">
        {{ __('word.income.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.income.meta.edit.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.income.meta.edit.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.income.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.income.meta.edit.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('js/total_and_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('js/payment_and_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/billcoin_button.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/income/ticketing_amount.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.income.resource.edit') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST"
                      action="{{route('incomes.update', $income->income_uuid)}}">
                    @csrf
                    @method("PUT" )
                    <div class="pt-4">
                        <h1 class="text-md font-bold italic block text-center">{{__('word.income.form_edit')}}</h1>
                        <x-form-income :income="$income"
                                       :services="$services"
                                       :data="$data"
                                       page="edit"/>
                        @if ($errors->any())
                            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
                                 role="alert">
                                <strong class="font-bold">{{__('word.general.validation')}}</strong>
                                <ul class="mt-2 ml-4 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <h1 class="text-md font-bold italic block text-center py-8">{{__('word.denomination.billcoin_charge')}}</h1>
                            <x-form-billcoin :denomination="$denomination_charge" :digital="true" :balance="true"/>
                        </div>
                        <div class="col-span-1">
                            <h1 class="text-md font-bold italic block text-center py-8">{{__('word.denomination.billcoin_payment')}}</h1>
                            <x-form-billcoin-payment :denomination="$denomination_payment"/>
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
