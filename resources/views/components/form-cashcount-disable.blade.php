<h1 class="text-md font-bold italic block text-center pb-8">{{__('word.denomination.billcoin')}}</h1>
<div class="grid grid-cols-3 gap-1 overflow-x-auto">
    <div class="col-span-1 md:ms-10 text-start">
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.bill_200') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.bill_100') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.bill_50') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.bill_20') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.bill_10') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_5') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_2') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_1') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_0_5') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_0_2') }}</p>
        <p class="block text-sm text-gray-600 py-2">{{ __('word.denomination.attribute.coin_0_1') }}</p>
    </div>
    <div class="col-span-1 flex justify-center flex-col items-center">
        <div data-name="bill_200"
             class="denomination-{{$form}} overflow-hidden  cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{  $denomination->bill_200 }}</div>
        <div data-name="bill_100"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->bill_100 }}</div>
        <div data-name="bill_50"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->bill_50 }}</div>
        <div data-name="bill_20"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->bill_20 }}</div>
        <div data-name="bill_10"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->bill_10 }}</div>
        <div data-name="coin_5"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_5 }}</div>
        <div data-name="coin_2"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_2 }}</div>
        <div data-name="coin_1"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_1 }}</div>
        <div data-name="coin_0_5"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_0_5 }}</div>
        <div data-name="coin_0_2"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_0_2 }}</div>
        <div data-name="coin_0_1"
             class="denomination-{{$form}} overflow-hidden cursor-default text-center w-20 px-3 py-[3.5px] mb-[5.0px] font-bold text-slate-600 bg-slate-50 border-0 rounded-lg shadow-md"
        >{{ $denomination->coin_0_1 }}</div>
    </div>
    <div class="col-span-1 md:me-10 text-end">
        <p data-name="bill_200" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->bill_200 }}</p>
        <p data-name="bill_100" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->bill_100 }}</p>
        <p data-name="bill_50" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->bill_50 }}</p>
        <p data-name="bill_20" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->bill_20 }}</p>
        <p data-name="bill_10" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->bill_10 }}</p>
        <p data-name="coin_5" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_5 }}</p>
        <p data-name="coin_2" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_2 }}</p>
        <p data-name="coin_1" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_1 }}</p>
        <p data-name="coin_0_5" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_0_5 }}</p>
        <p data-name="coin_0_2" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_0_2 }}</p>
        <p data-name="coin_0_1" class="operation-{{$form}} overflow-hidden block text-sm text-gray-600 py-2">{{ $operation->coin_0_1 }}</p>
    </div>
</div>
<div class="mt-6 grid grid-cols-3 gap-1 bg-white shadow-lg rounded-lg border border-gray-200">
    <p class="py-4 col-span-2 text-sm text-gray-600 md:ms-10 text-start">{{ __('word.denomination.attribute.total') }}</p>
    <p class="py-4 total-operation-{{$form}} overflow-hidden col-span-1 md:me-10 text-end text-sm text-gray-600">{{$denomination->total}}</p>
</div>





