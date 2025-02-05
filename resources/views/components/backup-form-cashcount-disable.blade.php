<p data-name="bill_200" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md hover:bg-white-400 active:bg-white-500 transition-all ease-in-out">{{  $denomination->bill_200 }}</p>
<p data-name="bill_100" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->bill_100 }}</p>
<p data-name="bill_50" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->bill_50 }}</p>
<p data-name="bill_20" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->bill_20 }}</p>
<p data-name="bill_10" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->bill_10 }}</p>
<p data-name="coin_5" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_5 }}</p>
<p data-name="coin_2" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_2 }}</p>
<p data-name="coin_1" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_1 }}</p>
<p data-name="coin_0_5" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_0_5 }}</p>
<p data-name="coin_0_2" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_0_2 }}</p>
<p data-name="coin_0_1" class="denomination-{{$form}} overflow-hidden col-span-1 cursor-default text-center w-20 px-3 py-1 mt-1 font-bold text-slate-600 bg-white-300 border-0 rounded-lg shadow-md">{{ $denomination->coin_0_1 }}</p>
<p class="col-span-1"></p>
<p data-name="bill_200" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->bill_200 ?? 0, 2) }}</p>
<p data-name="bill_100" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->bill_100 ?? 0, 2) }}</p>
<p data-name="bill_50" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->bill_50 ?? 0, 2) }}</p>
<p data-name="bill_20" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->bill_20 ?? 0, 2) }}</p>
<p data-name="bill_10" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->bill_10 ?? 0, 2) }}</p>
<p data-name="coin_5" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_5 ?? 0, 2) }}</p>
<p data-name="coin_2" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_2 ?? 0, 2) }}</p>
<p data-name="coin_1" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_1 ?? 0, 2) }}</p>
<p data-name="coin_0_5" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_0_5 ?? 0, 2) }}</p>
<p data-name="coin_0_2" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_0_2 ?? 0, 2) }}</p>
<p data-name="coin_0_1" class="operation-{{$form}} overflow-hidden block text-xs text-center text-gray-600 ">{{ number_format($operation->coin_0_1 ?? 0, 2) }}</p>
<p class="total-operation-{{$form}} col-span-1 text-sm text-center text-gray-600">{{number_format($denomination->total ?? 0,2)}}</p>



