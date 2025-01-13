<div class="text-center pb-8 md:pb-0 flex flex-col h-full bg-white overflow-hidden shadow-xl sm:rounded-lg"
     id="show-opening-modal">
    <p class="font-bold text-sm text-center py-4">{{$title}}</p>
    <hr class="py-2">
    <div class="">
            <div class="space-y-4 px-8">
                @foreach ([
                    ['value' => $data->bill_200, 'label' => '200', 'type' => 'Billete'],
                    ['value' => $data->bill_100, 'label' => '100', 'type' => 'Billete'],
                    ['value' => $data->bill_50,  'label' => '50',  'type' => 'Billete'],
                    ['value' => $data->bill_20,  'label' => '20',  'type' => 'Billete'],
                    ['value' => $data->bill_10,  'label' => '10',  'type' => 'Billete'],
                    ['value' => $data->coin_5,   'label' => '5',   'type' => 'Moneda'],
                    ['value' => $data->coin_2,   'label' => '2',   'type' => 'Moneda'],
                    ['value' => $data->coin_1,   'label' => '1',   'type' => 'Moneda'],
                    ['value' => $data->coin_0_5, 'label' => '0.5', 'type' => 'Moneda'],
                    ['value' => $data->coin_0_2, 'label' => '0.2', 'type' => 'Moneda'],
                    ['value' => $data->coin_0_1, 'label' => '0.1', 'type' => 'Moneda'],
                ] as $item)
                    <div class="flex items-center justify-between border-b pb-2">
                        <div id="initial-balance-{{ $item['type'] }}-{{ $item['label'] }}" class="text-gray-800 font-semibold">
                            {{ $item['value'] }}
                        </div>
                        <span class="text-sm text-gray-500">
                {{ $item['value'] == 1 ? "{$item['type']} de {$item['label']}" : "{$item['type']}s de {$item['label']}" }}
            </span>
                    </div>
                @endforeach
            </div>

       {{-- <div class="flex items-center justify-end pt-2 text-md px-4">
            <p class="w-2/3 text-right italic text-rose-600 font-medium">Bs-F.:</p>
            <p class="w-1/3 text-right font-semibold text-gray-800" id="initial-balance-total">
                {{ number_format($data->physical_cash, 2) }}
            </p>
        </div>--}}
    </div>
    <div class="flex flex-col flex-1 justify-end bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex font-extrabold text-lg mt-8 p-4 justify-end items-center bg-gray-50 rounded-b-lg">
            <p class="w-3/5 text-right italic text-rose-600">Bs Total:</p>
            <p class="w-2/5 text-right text-gray-900" id="initial-balance-total">
                {{ number_format($data->total, 2) }}
            </p>
        </div>
    </div>
</div>

