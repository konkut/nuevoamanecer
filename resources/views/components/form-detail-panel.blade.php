@foreach($detail as $item)
    <div class="flex gap-4 text-sm text-gray-700 text-center py-2">
        <div class="flex-1">{{$item->name}}</div>
        <div class="hidden sm:flex flex-1 justify-center">{{number_format($item->amount, 2) }}</div>
        <div class="hidden sm:flex flex-1 justify-center">{{number_format($item->commission, 2) }}</div>
        <div class="hidden sm:flex flex-1 justify-center">{{$item->quantity}}</div>
        <div class="flex-1">{{number_format($item->total, 2) }}</div>
    </div>
@endforeach
