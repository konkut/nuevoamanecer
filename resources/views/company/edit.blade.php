<x-app-layout>
    <x-slot name="title">
        {{ __('word.company.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.company.meta.edit.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.company.meta.edit.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.company.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.company.meta.edit.description')}}
    </x-slot>

    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.company.resource.edit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full sm:w-1/3 mx-auto p-8">
                <form method="POST" action="{{route('companies.update', $company->company_uuid)}}">
                    @csrf
                    @method("PUT" )
                    <x-form-company :company="$company" :activities="$activities" :businesstypes="$businesstypes"></x-form-company>
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
