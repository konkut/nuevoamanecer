
<div class="bg-white shadow-xl rounded-lg mt-8">
    <div class="p-6 text-gray-800">
        <div class="text-center mb-6">
            <h2 class="text-lg font-bold text-gray-700">{{__('word.panel.control.title')}}</h2>
            <p class="text-sm text-gray-500">{{__('word.panel.control.subtitle')}}</p>
        </div>
        <div class="overflow-x-auto">
            <a href="{{ route('control') }}"
               class="flex justify-center items-center bg-gray-200 text-dark text-sm font-medium py-2  rounded-lg hover:bg-gray-300 transition duration-200">
                <i class="bi bi-gear-fill mr-2"></i>
                {{__('word.panel.control.detail')}}
            </a>
        </div>
    </div>
</div>
