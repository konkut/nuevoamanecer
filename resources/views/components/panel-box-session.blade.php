<div onclick="fetch_session(this, '{{url('/')}}', '{{ $cashshift->cashshift_uuid }}', event)"
     class="mt-8 flex items-center justify-center flex-col sm:flex-row px-6 py-4 gap-4 rounded-lg shadow-md cursor-pointer hover:shadow-2xl transition-shadow text-white bg-blue-400">
    <p class="text-sm font-bold text-white">{{__('word.panel.session.title')}}</p>
    @if($cashshift->status || auth()->user()->hasRole('Administrador'))
    <form
        action="{{ $cashshift->status ? route('dashboards.off_session', $cashshift->cashshift_uuid) : route('dashboards.on_session', $cashshift->cashshift_uuid) }}"
        method="POST">
        @csrf
        @method('PUT')
        <button type="submit" id="toggleButton"
                class="w-12 h-6 rounded-full relative focus:outline-none transition-colors duration-200 {{ $cashshift->status ? 'bg-green-500' : 'bg-red-500' }}"
                onclick="event.stopPropagation(); toggleStatus()">
            <div
                class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform duration-200 {{ $cashshift->status ? 'translate-x-6 bg-green-600' : 'bg-red-600' }}"></div>
        </button>
        <input type="hidden" name="status" id="status" value="{{ $cashshift->status ? '1' : '0' }}">
    </form>
    @endif
    @if(!$cashshift->status && !auth()->user()->hasRole('Administrador'))
        <p class="text-sm font-bold ">{{__('word.panel.session.disabled')}}</p>
    @endif
    <div class="text-center text-sm">
        <p class="font-semibold">{{__('word.panel.session.box')}}</p>
        <p> {{ $cashshift->cash ?? __('word.general.name_cash_dashboard') }}</p>
    </div>
    <div class="text-center text-sm">
        <p class="font-semibold">{{__('word.panel.session.user')}}</p>
        <p> {{ $cashshift->user }}</p>
    </div>
    <div class="text-center text-sm">
        <p class="font-semibold">{{__('word.panel.session.start_time')}}</p>
        <p> {{ $cashshift->start_time }}</p>
    </div>
    <div class="text-center text-sm">
        <p class="font-semibold">{{__('word.panel.session.end_time')}}</p>
        <p> {{ $cashshift->end_time ?? __('word.general.end_time_dashboard') }}</p>
    </div>
</div>

<a id="session-form-{{ $cashshift->cashshift_uuid }}"
   href="{{ route('dashboards.session', $cashshift->cashshift_uuid) }}"
   style="display: none;">
</a>
