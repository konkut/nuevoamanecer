<x-guest-layout>
    <div id="content-two-factor">
        <div id="box-two-factor">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <p id="title-two-factor">
            {{ __('word.reset_password_email.email.text_1') }}<b>{{$data['name']}}</b>{{ __('word.reset_password_email.email.text_2') }}
        </p>
        <a id="link-reset-password" href="{{$link}}">{{$link}}</a>
        <p id="subtitle-reset-password">{{ __('word.reset_password_email.email.text_3') }}</p>
        <p id="message-two_factor">
            <strong>{{ __('word.reset_password_email.email.text_4') }}</strong>{{ __('word.reset_password_email.email.text_5') }}
        </p>
        <p id="description-two-factor">
            {{ __('word.reset_password_email.email.text_6') }}
            <b>{{ __('word.reset_password_email.email.title') }}</b>{{ __('word.reset_password_email.email.text_7') }}
        </p>
    </div>
</x-guest-layout>
