<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plan de Cuentas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #d1d5db; padding: 7px; text-align: left; }
        h2{ text-align: center; padding: 10px 0; font-size: 18px; text-decoration: underline}
        th { background-color: #d1d5db; font-size: 12px; }
        .nivel-1 { padding-left: 10px; font-weight: bold; }
        .nivel-2 { padding-left: 20px; }
        .nivel-3 { padding-left: 30px; }
        .nivel-4 { padding-left: 40px; font-style: italic; }
        .header {text-align: center;margin-bottom: 10px;}
        .header img {height: 70px;width: 70px;}
        .header div {margin-top: 16px;}
        .page {
            position: fixed;
            font-weight: 300;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="page">
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_text(530, 30, "Pág {PAGE_NUM}", null, 9, array(0,0,0));
        }
    </script>
</div>
<section class="header">
    <img src="{{ public_path('images/logo.png') }}" alt="logo Nuevo Amanecer">
    <div>
        <h1 style="font-size: 11px; margin: 0;">SERVICIO CONTABLE Y TRIBUTARIO</h1>
        <h3 style="font-size: 11px; margin: 0;">"NUEVO AMANECER"</h3>
    </div>
</section>
<h2>PLAN DE CUENTAS</h2>
<table>
    <tr>
        <th>NÚMERO DE CUENTA</th>
        <th>CUENTA</th>
    </tr>
    @foreach($accountclasses as $class)
        <tr>
            <td class="nivel-1">{{ $class->code }}</td>
            <td class="nivel-1">{{ $class->name }}</td>
        </tr>
        @foreach($class->groups as $group)
            <tr>
                <td class="nivel-2">{{ $group->code }}</td>
                <td class="nivel-2">{{ $group->name }}</td>
            </tr>
            @foreach($group->subgroups as $subgroup)
                <tr>
                    <td class="nivel-3">{{ $subgroup->code }}</td>
                    <td class="nivel-3">{{ $subgroup->name }}</td>
                </tr>
                @foreach($subgroup->accounts as $account)
                    <tr>
                        <td class="nivel-4">{{ $account->code }}</td>
                        <td class="nivel-4">{{ $account->name }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
</table>
</body>
</html>

