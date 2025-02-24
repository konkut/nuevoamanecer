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
<div style="background-color: #fff;display: block;margin: 0 auto;min-height: 100vh;min-width: 120px;max-width: 640px;width: 94%;overflow: hidden;">
    <div style="text-align: center; margin: 20px 0; display:block;">
        <img src="{{ url('storage/images/logo.png') }}" alt="Logo"
             style="width: 100px; display:block; margin: 0 auto 15px auto;">
    </div>
    <p style="font-size: 0.95rem;margin-bottom: 15px;text-align: center;color:#003f8a;">
        {{ __('word.reset_password_email.email.text_1') }}
        <b>{{$data['name']}}</b>{{ __('word.reset_password_email.email.text_2') }}
    </p>
    <a style="margin-bottom: 20px;font-size: 12px;font-weight: bold;color:#60A5FA;word-wrap: break-word;word-break: break-all;text-decoration: none;" href="{{$link}}">{{$link}}</a>
    <p style="margin-top: 20px;font-size: 0.95rem;color: #444444;text-align: justify;margin-bottom: 15px;">{{ __('word.reset_password_email.email.text_3') }}</p>
    <p style="font-size: 0.85rem;background-color: #FFF9E6;border: 1px solid #FFD700;color: #665200;padding: 10px 15px;text-align: justify;">
        <strong>{{ __('word.reset_password_email.email.text_4') }}</strong>{{ __('word.reset_password_email.email.text_5') }}
    </p>
    <p style="text-align: center;font-size: 0.85rem;color: #003f8a;margin-top: 30px;">
        {{ __('word.reset_password_email.email.text_6') }}
        <b>{{ __('word.reset_password_email.email.title') }}</b>{{ __('word.reset_password_email.email.text_7') }}
    </p>
</div>
</body>
</html>
