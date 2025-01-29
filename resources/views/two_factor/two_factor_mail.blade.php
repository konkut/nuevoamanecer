<x-guest-layout>
    <div id="content-two-factor">
            <div id="box-two-factor">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
            <p id="title-two-factor">
                {{ __('word.two_factor.email.text_1') }}<b>{{$name}}</b>{{ __('word.two_factor.email.text_2') }}
            </p>
            <div id="code-two-factor">{{$code}}</div>
            <p id="subtitle-two_factor">{{ __('word.two_factor.email.text_3') }}</p>
            <p id="message-two_factor">
                <strong>{{ __('word.two_factor.email.text_4') }}</strong>{{ __('word.two_factor.email.text_5') }}
            </p>
            <p id="description-two-factor">
                {{ __('word.two_factor.email.text_6') }}
                <b>{{ __('word.two_factor.email.title') }}</b>{{ __('word.two_factor.email.text_7') }}
            </p>
    </div>
</x-guest-layout>
