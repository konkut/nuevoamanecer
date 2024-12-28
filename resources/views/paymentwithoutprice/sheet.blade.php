<table>
    <thead>
    <tr>
        <th>Servicios</th>
        <th>Monto</th>
        <th>Comisión</th>
        <th>Método de transacción</th>
        <th>Bs 200</th>
        <th>Bs 100</th>
        <th>Bs 50</th>
        <th>Bs 20</th>
        <th>Bs 10</th>
        <th>Bs 5</th>
        <th>Bs 2</th>
        <th>Bs 1</th>
        <th>Bs 0.5</th>
        <th>Bs 0.2</th>
        <th>Bs 0.1</th>
        <th>Físico</th>
        <th>Digital</th>
        <th>Total</th>
        <th>Usuario</th>
        <th>Fecha de registro</th>
        <th>Fecha de actualización</th>
    </tr>
    </thead>
    <tbody>
    @foreach($paymentwithoutprices as $item)
        <tr>
            <td>{{$item->format_paymentwithoutprice_uuids}}</td>
            <td>{{$item->format_amounts}}</td>
            <td>{{$item->format_commissions}}</td>
            <td>{{$item->format_servicewithprice_uuids}}</td>
            <td>{{$item->format_bill_200}}</td>
            <td>{{$item->format_bill_100}}</td>
            <td>{{$item->format_bill_50}}</td>
            <td>{{$item->format_bill_20}}</td>
            <td>{{$item->format_bill_10}}</td>
            <td>{{$item->format_coin_5}}</td>
            <td>{{$item->format_coin_2}}</td>
            <td>{{$item->format_coin_1}}</td>
            <td>{{$item->format_coin_0_5}}</td>
            <td>{{$item->format_coin_0_2}}</td>
            <td>{{$item->format_coin_0_1}}</td>
            <td>{{$item->format_physical_cash}}</td>
            <td>{{$item->format_digital_cash}}</td>
            <td>{{$item->format_total}}</td>
            <td>{{$item->format_user_id}}</td>
            <td>{{$item->format_created_at}}</td>
            <td>{{$item->format_updated_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
