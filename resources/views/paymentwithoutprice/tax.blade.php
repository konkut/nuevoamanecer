<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!--AQUI-->
    <meta name="routeName" content="{{ Route::currentRouteName() }}">
    <link rel="shortcut icon" href="{{url('images/icono.ico')}}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <link rel="stylesheet" href="{{ url('css/components/alert.css?v='.time()) }}">
    <script type="text/javascript" src="{{ url('js/app.js?v='.time()) }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>Comprobante de pago - {{__('word.general.app') }}</title>
</head>
<body>
<section>
    <div style="width: 100%;">
        <img src="{{ public_path('images/logo.png') }}" style="height: 50px; width: 50px; display: inline-block;" alt="logo Nuevo Amanecer">
        <div style="display: inline-block; padding-left: 7px; text-align: center;">
            <h1 style="font-size: 11px;">SERVICIO CONTABLE Y TRIBUTARIO</h1>
            <h2 style="font-size: 11px;">"NUEVO AMANECER"</h2>
        </div>
    </div>
</section>
<p style="font-size: 8px; text-align: center; margin: 0; line-height: 0.2;">-----------------------------------------------------------------------------------------------------------------------</p>
<section>
    <p style="font-size: 11px; text-align: center; line-height: 0.1; margin-top: 17px;"><b>CASA MATRIZ</b></p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1;">AV. DEL ARQUITECTO N° 4 - ZONA FERROPETROL</p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1; margin-top: 17px;"><b>SUCURSAL</b></p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1;">CALLE JOSE ARZABE EDIF. TERMINAL INTERPROVINCIAL</p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1;">EL ALTO PISO 1 DEPTO. OF. 2 ZONA VILLA EXPERANZA</p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1;">EL ALTO - BOLIVIA</p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1; margin-top: 17px;"><b>CELULAR</b></p>
    <p style="font-size: 11px; text-align: center; line-height: 0.1;">75231304 - 60631216</p>
</section>
<p style="font-size: 8px; text-align: center; line-height: 0.2;">-----------------------------------------------------------------------------------------------------------------------</p>
<section>
    {{--<p style="font-size: 10px; text-align: center; line-height: 0.3;"><b>NIT: </b>6889122011</p>--}}
    <p style="font-size: 11px; text-align: center; line-height: 0.1; margin-top: 17px;"><b>COMPROBANTE DE PAGO</b></p>
    <p style="font-size: 10px; text-align: center; line-height: 0.3;"><b>COMPROBANTE N°.: </b>1</p>
    <p style="font-size: 10px; text-align: center; line-height: 0.3;"><b>FECHA DE EMISIÓN: </b>{{$paymentwithoutprice->created_at}}</p>
</section>
<p style="font-size: 8px; text-align: center; line-height: 0.2;">-----------------------------------------------------------------------------------------------------------------------</p>
<section>
    <p style="font-size: 11px; text-align: center; line-height: 0.2; margin-top: 17px;"><b>DETALLE</b></p>

    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: left;">{{ implode(', ', $paymentwithoutprice->services->toArray()) }}</p>
    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: right;">{{ $paymentwithoutprice->pagar }}</p>
    <div style="line-height: 0.1; margin: 0;clear: both;"></div>

    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: right;"><b>TOTAL:</b>&nbsp;&nbsp;&nbsp;{{ $paymentwithoutprice->pagar }}</p>
    <div style="line-height: 0.1; margin: 0; clear: both;"></div>

    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: right;"><b>{{ strtoupper(implode(', ', $paymentwithoutprice->methods->toArray())) }}:&nbsp;&nbsp;&nbsp;</b>{{ $paymentwithoutprice->cobrado }}</p>
    <div style="line-height: 0.1; margin: 0; clear: both;"></div>

    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: right;"><b>CAMBIO:&nbsp;&nbsp;&nbsp;</b>{{ $paymentwithoutprice->cambio }}</p>
    <div style="line-height: 0.1; margin: 0; clear: both;"></div>

    <p style="font-size: 11px; line-height: 0.1; display: inline-block; float: right;"><b>MONTO A PAGAR:&nbsp;&nbsp;&nbsp;</b>{{ $paymentwithoutprice->pagar }}</p>
    <div style="line-height: 0.1; margin: 0; clear: both;"></div>
</section>
<p style="text-align: center; font-size: 8px; line-height: 0.1; margin-top: 17px;">GRACIAS POR SU PREFERENCIA</p>
</body>
</html>
