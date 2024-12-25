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
    <title>Arqueo de caja - {{__('word.general.app') }}</title>
</head>
<body>

<section>
    <div style=" width: 100%; padding: 10px 0;">
        <img src="{{ public_path('images/logo.png') }}"
             alt="logo Nuevo Amanecer"
             style="width: 70px; height: 70px; margin-right: 20px; ">

        <div style="text-align: center; display: inline-block; width: 80%;">
            <h1 style="font-size: 18px; margin: 0; font-weight: bold;">CONSULTORA DE SERVICIO CONTABLE Y TRIBUTARIO</h1>
            <h2 style="font-size: 16px; margin: 0; font-style: italic;">"NUEVO AMANECER"</h2>
            <p style="font-size: 14px; margin-top: 5px;">Arqueo de Caja - {{$cashflowdaily->date}}</p>
        </div>
    </div>
</section>
<section>
    <div style="width:100%;">
        <div style="float: left; width: 20%;">
            <table style="width: 100%; margin-top: 8px; font-size: 12px;">
                <thead>
                <tr style="background-color: #d1d5db44;">
                    <th colspan="2"
                        style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                        TOTAL APERTURA
                    </th>
                </tr>
                <tr style="background-color: #d1d5db44;">
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">
                        Denominación
                    </th>
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 200</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->bill_200}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 100</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->bill_100}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 50</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->bill_50}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 20</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->bill_20}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 10</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->bill_10}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_1}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_0_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_0_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->coin_0_1}}</td>
                </tr>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Total</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_opening->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left; width: 20%;">
            <table style="width: 100%; margin-top: 8px; font-size: 12px;">
                <thead>
                <tr style="background-color: #d1d5db44;">
                    <th colspan="2"
                        style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                        TOTAL INGRESOS
                    </th>
                </tr>
                <tr style="background-color: #d1d5db44;">
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">
                        Denominación
                    </th>
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 200</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->bill_200}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 100</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->bill_100}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 50</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->bill_50}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 20</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->bill_20}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 10</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->bill_10}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_1}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_0_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_0_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->coin_0_1}}</td>
                </tr>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Total</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_incomes->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left; width: 20%;">
            <table style="width: 100%; margin-top: 8px; font-size: 12px;">
                <thead>
                <tr style="background-color: #d1d5db44;">
                    <th colspan="2"
                        style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                        TOTAL EGRESOS
                    </th>
                </tr>
                <tr style="background-color: #d1d5db44;">
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">
                        Denominación
                    </th>
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 200</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->bill_200}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 100</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->bill_100}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 50</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->bill_50}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 20</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->bill_20}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 10</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->bill_10}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_1}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_0_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_0_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->coin_0_1}}</td>
                </tr>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Total</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_expenses->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left; width: 20%;">
            <table style="width: 100%; margin-top: 8px; font-size: 12px;">
                <thead>
                <tr style="background-color: #d1d5db44;">
                    <th colspan="2"
                        style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                        TOTAL CIERRE
                    </th>
                </tr>
                <tr style="background-color: #d1d5db44;">
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">
                        Denominación
                    </th>
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 200</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->bill_200}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 100</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->bill_100}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 50</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->bill_50}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 20</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->bill_20}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 10</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->bill_10}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_1}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_0_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_0_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->coin_0_1}}</td>
                </tr>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Total</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_closing->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="float: left; width: 20%;">
            <table style="width: 100%; margin-top: 8px; font-size: 12px;">
                <thead>
                <tr style="background-color: #d1d5db44;">
                    <th colspan="2"
                        style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                        TOTAL FISICO
                    </th>
                </tr>
                <tr style="background-color: #d1d5db44;">
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">
                        Denominación
                    </th>
                    <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 200</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->bill_200}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 100</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->bill_100}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 50</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->bill_50}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 20</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->bill_20}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 10</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->bill_10}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_1}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.5</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_0_5}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.2</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_0_2}}</td>
                </tr>
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Bs 0.1</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->coin_0_1}}</td>
                </tr>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Total</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$denomination_physical->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div style="line-height: 0.1; margin: 0;clear: both;"></div>
<section>
    <div style="float: left; width: 35%;">
        <table style="width: 100%; margin-top: 8px; font-size: 12px;">
            <thead>
            <tr style="background-color: #d1d5db44;">
                <th colspan="4"
                    style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                    TOTAL SERVICIOS
                </th>
            </tr>
            <tr style="background-color: #d1d5db44;">
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Servicio</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cantidad</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Precio</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Comisión</th>
            </tr>
            </thead>
            <tbody>
            @foreach($total_services as $key => $value)
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->servicio}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->cantidad}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->monto}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->commission}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>
<section>
    <div style="float: left; width: 65%;">
        <table style="width: 100%; margin-top: 8px; font-size: 12px;">
            <thead>
            <tr style="background-color: #d1d5db44;">
                <th colspan="6"
                    style="width: 50%; border-bottom: 1px solid #ccc; padding: 8px; text-align: center;">
                    SESIONES DE CAJA
                </th>
            </tr>
            <tr style="background-color: #d1d5db44;">
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cajero</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Caja</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Apertura</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Ingresos</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Egresos</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Cierre</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Físico</th>
                <th style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">Diferencia</th>
            </tr>
            </thead>
            <tbody>
            @foreach($detail_cashshift as $key => $value)
                <tr>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->user}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->cash}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->initial_balance}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->incomes_balance}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->expenses_balance}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->closing_balance}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->physical_balance}}</td>
                    <td style="width: 50%; border-bottom: 1px solid #ccc; padding: 4px; text-align: center;">{{$value->difference_balance}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</section>

</body>
</html>
