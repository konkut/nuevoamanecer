<table>
    <thead>
    <tr>
        <th>{{__('word.revenue.sheet.service')}}</th>
        <th>{{__('word.revenue.sheet.observation')}}</th>
        <th>{{__('word.revenue.sheet.customer')}}</th>
        <th>{{__('word.revenue.sheet.method')}}</th>
        <th>{{__('word.revenue.sheet.total')}}</th>
        <th>{{__('word.revenue.sheet.user')}}</th>
        <th>{{__('word.revenue.sheet.created_at')}}</th>
        <th>{{__('word.revenue.sheet.updated_at')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($revenues as $item)
        <tr>
            <td>{{$item->format_services}}</td>
            <td>{{$item->format_observation}}</td>
            <td>{{$item->format_customer}}</td>
            <td>{{$item->format_methods}}</td>
            <td>{{number_format($item->format_total, 2, '.', '')}}</td>
            <td>{{$item->format_user}}</td>
            <td>{{$item->format_created_at}}</td>
            <td>{{$item->format_updated_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
