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
    <title>Factura - {{__('word.general.app') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            width: 375px; /* Media carta */
            margin: auto;
            padding: 30px;
            color: #222;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-container img {
            height: 60px;
            width: 60px;
        }

        .logo-container div {
            text-align: center;
            margin-top: 20px;
        }

        .separator {
            border-top: 1px dashed #aaa;
        }

        .text-center {
            text-align: center;
        }

        .detail-container {
            display: table;
            width: 100%;
            padding: 3px 0;
        }

        .detail-row {
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
        section p{
            line-height: 10px;
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
    <p><strong>OFICINA CENTRAL</strong></p>
    <p>Calle José Arzabe, Edificio Terminal Interprovincial</p>
    <p>Piso 1, Oficina 2 - Zona Villa Esperanza</p>
    <p>El Alto, La Paz - Bolivia</p>
    <p><strong>CONTACTO</strong></p>
    <p>Teléfono: 75231304 - 60631216</p>
    <p><strong>FACTURA</strong></p>
    <p>(Este documento no es válido para crédito fiscal)</p>
</section>
<div class="separator"></div>
<section class="text-center">
    <p><strong>NIT EMPRESA:</strong> 6889122011</p>
    <p><strong>N° DE FACTURA:</strong> {{$revenue->code}}</p>
</section>
<div class="separator"></div>
<section class="text-center">
    <p><strong>FECHA DE EMISIÓN:</strong> {{$revenue->date}}</p>
    <p><strong>NIT CLIENTE:</strong> {{$revenue->customer->nit}}</p>
    <p><strong>NOMBRE DEL CLIENTE:</strong> {{$revenue->customer->name}}</p>
</section>
<div class="separator"></div>
<section>
    <p class="text-center"><b>DETALLE</b></p>
    @foreach($revenue->data as $item)
        <div class="detail-container">
            <div class="detail-row">
                <span class="left">{{ $item->name }}</span>
                <span class="right">{{ number_format($item->price, 2, '.', '') }}</span>
            </div>
        </div>
    @endforeach
    <div class="total-container">
        <p><b>TOTAL:</b> {{ $revenue->total }}</p>
        @if($revenue->cashregister)
            <p><b>{{ $revenue->cashregister }}:</b> {{ $revenue->received }}</p>
        @endif
        @if($revenue->bankregister)
            <p><b>{{ $revenue->bankregister }}:</b> {{ $revenue->bankregister_total }}</p>
        @endif
        @if($revenue->platform)
            <p><b>{{ $revenue->platform }}:</b> {{ $revenue->platform_total }}</p>
        @endif
        @if($revenue->returned)
            <p><b>CAMBIO:</b> {{ $revenue->returned }}</p>
        @endif
        <p><b>MONTO A PAGAR:</b> {{ $revenue->total }}</p>
    </div>
</section>
<div class="separator"></div>
<section class="text-center" style="margin-top: 7px; font-size: 10px;">
    <p><strong>Usuario:</strong> {{$revenue->user}}</p>
    <p><strong>Fecha de impresión:</strong> {{$revenue->date}}</p>
    <p><strong>GRACIAS POR SU PREFERENCIA</strong></p>
</section>
</body>
</html>
