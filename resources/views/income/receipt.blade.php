<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <link rel="shortcut icon" href="{{url('images/icono.ico')}}" type="image/x-icon">
    <title>Comprobante de pago - {{__('word.general.app') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            width: 375px; /* Media carta */
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-container img {
            height: 70px;
            width: 70px;
        }

        .logo-container div {
            text-align: center;
            margin-top: 20px;
        }

        .separator {
            border-top: 1px dashed black;
            margin: 10px 0;
        }

        .text-center {
            text-align: center;
        }

        .detalle-container {
            display: table;
            width: 100%;
            padding: 3px 0;
        }
        .detalle-row {
            display: table-row;
        }
        .left, .right {
            display: table-cell;
            vertical-align: middle;
        }
        .left {
            text-align: left;
            width: 80%;
        }
        .right {
            text-align: right;
            width: 20%;
            white-space: nowrap;
        }
        .total-container {
            text-align: right;
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<section class="header">
    <div class="logo-container">
        <img src="{{ public_path('images/logo.png') }}" alt="logo Nuevo Amanecer">
        <div>
            <h1 style="font-size: 11px; margin: 0;">SERVICIO CONTABLE Y TRIBUTARIO</h1>
            <h2 style="font-size: 11px; margin: 0;">"NUEVO AMANECER"</h2>
        </div>
    </div>
</section>
<div class="separator"></div>
<section class="text-center">
    <p><b>CASA MATRIZ</b></p>
    <p>CALLE JOSE ARZABE EDIF. TERMINAL INTERPROVINCIAL</p>
    <p>EL ALTO PISO 1 DEPTO. OF. 2 ZONA VILLA EXPERANZA</p>
    <p>EL ALTO - BOLIVIA</p>
    <p><b>CELULAR</b></p>
    <p>75231304 - 60631216</p>
</section>
<div class="separator"></div>
<section class="text-center">
    <p><b>COMPROBANTE DE PAGO</b></p>
    <p><b>COMPROBANTE N°:</b> {{$income->code}}</p>
    <p><b>FECHA DE EMISIÓN:</b> {{$income->date}}</p>
</section>
<div class="separator"></div>
<section>
    <p class="text-center"><b>DETALLE</b></p>
    @foreach($income->data as $item)
        <div class="detalle-container">
            <div class="detalle-row">
                <span class="left">{{ $item->quantity }} {{ $item->name }}</span>
                <span class="right">{{ number_format($item->price, 2, '.', '') }}</span>
            </div>
        </div>
    @endforeach
    <div class="total-container">
        @if($income->commission)
            <p><b>REP. FORMULARIO:</b> {{ $income->commission }}</p>
        @endif
            <p><b>TOTAL:</b> {{ $income->total }}</p>
        @if($income->cashregister)
            <p><b>{{ $income->cashregister }}:</b> {{ $income->received }}</p>
        @endif
        @if($income->bankregister)
            <p><b>{{ $income->bankregister }}:</b> {{ $income->bankregister_total }}</p>
        @endif
        @if($income->platform)
            <p><b>{{ $income->platform }}:</b> {{ $income->platform_total }}</p>
        @endif
        <p><b>CAMBIO:</b> {{ $income->returned }}</p>
        <p><b>MONTO A PAGAR:</b> {{ $income->total }}</p>
    </div>
</section>
<div class="separator"></div>
<div class="text-center">Gracias por su preferencia</div>
<div class="text-center">Usuario: {{$income->user}}</div>

</body>
</html>
