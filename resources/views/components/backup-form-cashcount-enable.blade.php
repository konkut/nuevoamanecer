<input id="bill_200"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="bill_200" inputmode="numeric" autocomplete="one-time-code" data-denomination="200"
       data-index="0" onkeyup="operation_billcoin(this)" value="{{ old('bill_200', $denomination->bill_200 ?? 0) }}"/>
<input id="bill_100"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="bill_100" inputmode="numeric" autocomplete="one-time-code" data-denomination="100"
       data-index="1" onkeyup="operation_billcoin(this)" value="{{ old('bill_100', $denomination->bill_100 ?? 0) }}"/>
<input id="bill_50"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="bill_50" inputmode="numeric" autocomplete="one-time-code" data-denomination="50" data-index="2"
       onkeyup="operation_billcoin(this)" value="{{ old('bill_50', $denomination->bill_50 ?? 0) }}"/>
<input id="bill_20"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="bill_20" inputmode="numeric" autocomplete="one-time-code" data-denomination="20" data-index="3"
       onkeyup="operation_billcoin(this)" value="{{ old('bill_20', $denomination->bill_20 ?? 0) }}"/>
<input id="bill_10"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="bill_10" inputmode="numeric" autocomplete="one-time-code" data-denomination="10" data-index="4"
       onkeyup="operation_billcoin(this)" value="{{ old('bill_10', $denomination->bill_10 ?? 0) }}"/>
<input id="coin_5"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_5" inputmode="numeric" autocomplete="one-time-code" data-denomination="5" data-index="5"
       onkeyup="operation_billcoin(this)" value="{{ old('coin_5', $denomination->coin_5 ?? 0) }}"/>
<input id="coin_2"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_2" inputmode="numeric" autocomplete="one-time-code" data-denomination="2" data-index="6"
       onkeyup="operation_billcoin(this)" value="{{ old('coin_2', $denomination->coin_2 ?? 0) }}"/>
<input id="coin_1"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_1" inputmode="numeric" autocomplete="one-time-code" data-denomination="1" data-index="7"
       onkeyup="operation_billcoin(this)" value="{{ old('coin_1', $denomination->coin_1 ?? 0) }}"/>
<input id="coin_0_5"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_0_5" inputmode="numeric" autocomplete="one-time-code" data-denomination="0.5"
       data-index="8" onkeyup="operation_billcoin(this)" value="{{ old('coin_0_5', $denomination->coin_0_5 ?? 0) }}"/>
<input id="coin_0_2"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_0_2" inputmode="numeric" autocomplete="one-time-code" data-denomination="0.2"
       data-index="9" onkeyup="operation_billcoin(this)" value="{{ old('coin_0_2', $denomination->coin_0_2 ?? 0) }}"/>
<input id="coin_0_1"
       class="denomination-{{$form}} cursor-pointer col-span-1 text-center w-20 px-3 py-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
       type="text" name="coin_0_1" inputmode="numeric" autocomplete="one-time-code" data-denomination="0.1"
       data-index="10" onkeyup="operation_billcoin(this)" value="{{ old('coin_0_1', $denomination->coin_0_1 ?? 0) }}"/>
<p class="hidden col-span-1" id="token" data-token="{{$token}}"></p>
<p data-name="bill_200" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->bill_200 ?? 0, 2) }}</p>
<p data-name="bill_100" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->bill_100 ?? 0, 2) }}</p>
<p data-name="bill_50" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->bill_50 ?? 0, 2) }}</p>
<p data-name="bill_20" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->bill_20 ?? 0, 2) }}</p>
<p data-name="bill_10" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->bill_10 ?? 0, 2) }}</p>
<p data-name="coin_5" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_5 ?? 0, 2) }}</p>
<p data-name="coin_2" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_2 ?? 0, 2) }}</p>
<p data-name="coin_1" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_1 ?? 0, 2) }}</p>
<p data-name="coin_0_5" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_0_5 ?? 0, 2) }}</p>
<p data-name="coin_0_2" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_0_2 ?? 0, 2) }}</p>
<p data-name="coin_0_1" class="operation-{{$form}} overflow-hidden col-span-1 text-center block text-xs text-gray-600">{{ number_format($operation->coin_0_1 ?? 0, 2) }}</p>
<input type="text" readonly id="total" name="total"
       class="total-operation-{{$form}} col-span-1 outline-none border-none select-none focus:ring-0 text-gray-600 text-sm cursor-default text-center p-0"
       value="{{ old('total', number_format($denomination->total ?? 0, 2)) }}">

