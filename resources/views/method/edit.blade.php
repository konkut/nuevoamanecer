<x-app-layout>
    <x-slot name="title">
        {{ __('word.method.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.method.meta.edit.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.method.meta.edit.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.method.meta.edit.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.method.meta.edit.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/toggle.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/validation_input.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('word.method.resource.edit') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg w-full sm:w-1/3 mx-auto p-8">
                <form method="POST" action="{{route('methods.update', $method->method_uuid)}}">
                    @csrf
                    @method("PUT" )
                    <x-form-method :method="$method" :bankregisters="$bankregisters"></x-form-method>
                    <div class="mt-4">
                        <x-label for="status" value="{{ __('word.method.attribute.status') }}" />
                        <div class="relative flex items-center">
              <span id="toggleStatus" class="mr-2 text-gray-700 {{ $method->status ? 'text-green-500' : 'text-red-500' }}">
                {{ $method->status ? 'On' : 'Off' }}
              </span>
                            <button type="button" id="toggleButton"
                                    class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $method->status ? 'bg-green-500' : 'bg-red-500' }}"
                                    onclick="toggleStatus()">
                                <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $method->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                            </button>
                            <input type="hidden" name="status" id="status" value="{{ $method->status ? '1' : '0' }}">
                        </div>
                    </div>
                    <x-button class="mt-4 flex ">
                        {{ __('Save') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
