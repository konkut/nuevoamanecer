<div
    class="bg-white block overflow-hidden shadow-xl sm:rounded-lg mt-8 cursor-pointer hover:shadow-2xl transition-shadow duration-300"
    onclick="fetch_all_sesions(event,this)">
    <div class="flex items-center justify-center p-6 gap-4 text-center text-gray-800 rounded-lg">
        <div
            class="flex items-center justify-center bg-blue-100 text-blue-500 w-12 h-12 rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 9l3 3-3 3m4-6l3 3-3 3M2 12h20"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-gray-700">{{__('word.panel.all-sessions.title')}}</p>
            <p class="text-xs text-gray-500">{{__('word.panel.all-sessions.subtitle')}}</p>
        </div>
    </div>
</div>
<a id="state-sessions-form"
   href="{{ route('dashboards.sesions') }}"
   style="display: none;">
</a>
