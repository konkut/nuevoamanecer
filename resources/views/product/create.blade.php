<x-app-layout>
    <x-slot name="title">
        {{ __('word.product.meta.create.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.product.meta.create.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.product.meta.create.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.product.meta.create.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.product.meta.create.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.product.resource.create') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full sm:w-1/3 mx-auto p-8">
                <form method="POST" action="{{route('products.store')}}">
                    @csrf
                    <x-form-product :categories="$categories" :product="$product"></x-form-product>
                    <x-button class="mt-4 flex">
                        {{ __('Save') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>