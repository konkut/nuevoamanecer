<x-app-layout>
    <x-slot name="title">
        {{ __('word.voucher.meta.create.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.voucher.meta.create.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.voucher.meta.create.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.voucher.meta.create.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.voucher.meta.create.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/voucher/voucher_balance.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/voucher/search_account.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/validation_input.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.voucher.resource.create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full mx-auto p-8">
                <form method="POST" action="{{ route('vouchers.store') }}">
                    @csrf
                    <x-form-voucher :voucher="$voucher" :projects="$projects" :accounts="$accounts" page="create"></x-form-voucher>
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
                    <div class="mt-4 flex justify-end">
                        <x-button>
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

