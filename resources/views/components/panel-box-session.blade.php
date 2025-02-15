<div onclick="fetch_session(this, '{{url('/')}}', '{{ $cashshift->cashshift_uuid }}', event)"
    class="block bg-white mt-8 flex-col overflow-hidden shadow-xl sm:rounded-lg cursor-pointer">
    <div class="flex p-6 text-center text-gray-800 rounded-lg shadow-md flex-wrap">
        <div class="flex-1 flex-col items-center justify-center">
            <p class="text-sm font-extrabold text-gray-700 mb-2">{{__('word.panel.session.title')}}</p>
            <div class="mb-2"><span id="toggleStatus" class="mr-2 text-sm text-gray-700 {{ $cashshift->status ? 'text-green-500' : 'text-red-500' }}">{{ $cashshift->status ? 'Habilitado' : 'Deshabilitado' }}</span>
                <form action="{{ $cashshift->status ? route('dashboards.off_session', $cashshift->cashshift_uuid) : route('dashboards.on_session', $cashshift->cashshift_uuid) }}" method="POST">

                @csrf
                    @method('PUT')
                    <button type="submit" id="toggleButton"
                            class="bg-gray-300 rounded-full w-12 h-6 relative focus:outline-none transition-colors duration-200 {{ $cashshift->status ? 'bg-green-500' : 'bg-red-500' }}"
                            onclick="event.stopPropagation(); toggleStatus()">
                        <div class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $cashshift->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
                    </button>
                    <input type="hidden" name="status" id="status" value="{{ $cashshift->status ? '1' : '0' }}">
                </form>
            </div>
            <p class="text-sm text-gray-500">{{__('word.panel.session.subtitle')}}</p>
            <div class="flex-1 rounded-lg p-4 text-center text-xs text-gray-600 space-y-3">
                <p><span class="font-semibold text-gray-700">{{__('word.panel.session.box')}}</span> {{$cashshift->cash ?? "No asignado"}}</p>
                <p><span class="font-semibold text-gray-700">{{__('word.panel.session.user')}}</span> {{$cashshift->user}}</p>
                <p><span class="font-semibold text-gray-700 py-2">{{__('word.panel.session.start_time')}}<br> </span> {{$cashshift->start_time}}</p>
                <p><span class="font-semibold text-gray-700 py-2">{{__('word.panel.session.end_time')}}<br></span> {{$cashshift->end_time??'Pendiente'}}</p>
                @if($cashshift->observation)
                    <p><span class="font-semibold text-gray-700">{{__('word.panel.session.observation')}}</span> {{$cashshift->observation}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<a id="session-form-{{ $cashshift->cashshift_uuid }}"
   href="{{ route('dashboards.session', $cashshift->cashshift_uuid) }}"
   style="display: none;">
</a>



