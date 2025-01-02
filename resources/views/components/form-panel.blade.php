<div class="text-center pb-8 md:pb-0 flex flex-col h-full"
     id="show-opening-modal">
    <p class="font-bold text-sm text-center py-4">{{$title}}</p>
    <hr class="py-2">
    <div class="divide-y divide-[#f3f4f6]">
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/200.ico') }}" alt="Billete de 200 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-bill-200">{{$data->bill_200}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->bill_200==1?'Billete':'Billetes'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/100.ico') }}" alt="Billete de 100 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-bill-100">{{$data->bill_100}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->bill_100==1?'Billete':'Billetes'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/50.ico') }}" alt="Billete de 50 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-bill-50">{{$data->bill_50}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->bill_50==1?'Billete':'Billetes'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/20.ico') }}" alt="Billete de 20 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-bill-20">{{$data->bill_20}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->bill_20==1?'Billete':'Billetes'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/10.ico') }}" alt="Billete de 10 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-bill-10">{{$data->bill_10}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->bill_10==1?'Billete':'Billetes'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/5.ico') }}" alt="Moneda de 5 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-5">{{$data->coin_5}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_5==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/2.ico') }}" alt="Moneda de 2 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-2">{{$data->coin_2}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_2==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/1.ico') }}" alt="Moneda de 1 Bolivianos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-1">{{$data->coin_1}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_1==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/05.ico') }}" alt="Moneda de 50 Centavos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-0-5">{{$data->coin_0_5}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_0_5==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/02.ico') }}" alt="Moneda de 20 Centavos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-0-2">{{$data->coin_0_2}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_0_2==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div class="flex py-1">
            <p class="flex flex-1 justify-end items-center pr-4">
                <img src="{{ asset('images/panel/01.ico') }}" alt="Moneda de 10 Centavos">
            </p>
            <div class="flex flex-1 justify-start items-center pl-4"
                 id="initial-balance-coin-0-1">{{$data->coin_0_1}}&nbsp;
                <span
                    class="text-sm text-gray-500">{{$data->coin_0_1==1?'Moneda':'Monedas'}}</span>
            </div>
        </div>
        <div
            class="flex pt-2 text-md justify-end items-center">
            <p class="w-2/3 text-end italic text-rose-700">Bs-F.:</p>
            <p class="w-1/3 text-end" id="initial-balance-total">{{number_format($data->physical_cash, 2) }}</p>
        </div>
    </div>
    <div class="flex flex-col flex-1 justify-end">
        <div class="divide-y divide-[#f3f4f6] pt-8">
            @if($incomesdigital && $expensesdigital === false)
                @foreach($incomesdigital as $key => $item)
                    <div class="flex py-1 justify-end items-center">
                        <p class="w-2/3 text-end">{{ \Illuminate\Support\Str::limit($key, 5, '...') }}</p>
                        <p class="w-1/3 text-end">{{number_format($item, 2) }}</p>
                    </div>
                @endforeach
            @endif
            @if($expensesdigital && $incomesdigital === false)
                @foreach($expensesdigital as $key => $item)
                    <div class="flex py-1 justify-end items-center">
                        <p class="w-2/3 text-end">{{ \Illuminate\Support\Str::limit($key, 5, '...') }}</p>
                        <p class="w-1/3 text-end">{{number_format($item, 2) }}</p>
                    </div>
                @endforeach
            @endif
            <div
                class="flex pt-2 text-md justify-end items-center">
                <p class="w-2/3 text-end italic text-rose-700">Bs-D.:</p>
                <p class="w-1/3 text-end" id="initial-balance-total"> {{number_format($data->digital_cash, 2) }}</p>
            </div>
        </div>
        <div class="flex font-extrabold text-lg mt-8 p-2 justify-end items-center">
            <p class="w-3/5 text-end italic text-rose-700">Bs Total:</p>
            <div class="w-2/5 text-end" id="initial-balance-total">{{number_format($data->total, 2) }}</div>
        </div>
    </div>
</div>
