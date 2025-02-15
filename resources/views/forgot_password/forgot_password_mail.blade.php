<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="{{ url('storage/css/mail.css?v='.time()) }}">
    <title>{{__('word.general.app')}}</title>
</head>
<body>
<div id="content-two-factor">
    <div id="box-two-factor">
        <img src="{{ url('storage/images/logo.png') }}" alt="Logo">
    </div>
    <p id="title-two-factor">
        {{ __('word.reset_password_email.email.text_1') }}
        <b>{{$data['name']}}</b>{{ __('word.reset_password_email.email.text_2') }}
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
</body>
</html>
