
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
    <div class="space-y-2">
        <div class="flex items-center justify-evenly">
            <x-label for="bil_200" value="Bs. {{ __('word.denomination.attribute.bill_200') }}"/>
            <input id="bil_200"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="bil_200" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('bil_200', $denomination->bill_200 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="bil_100" value="Bs. {{ __('word.denomination.attribute.bill_100') }}"/>
            <input id="bil_100"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="bil_100" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('bil_100', $denomination->bill_100 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="bil_50" value="Bs. {{ __('word.denomination.attribute.bill_50') }}"/>
            <input id="bil_50"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="bil_50" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('bil_50', $denomination->bill_50 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="bil_20" value="Bs. {{ __('word.denomination.attribute.bill_20') }}"/>
            <input id="bil_20"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="bil_20" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('bil_20', $denomination->bill_20 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="bil_10" value="Bs. {{ __('word.denomination.attribute.bill_10') }}"/>
            <input id="bil_10"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="bil_10" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('bil_10', $denomination->bill_10 ?? 0) }}"/>
        </div>
        <div class="hidden sm:flex items-center justify-center pt-4">
            <a href="#" onclick="clear_billcoin_payment(this)" title="Limpiar campos"
               class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3"
                     viewBox="0 0 16 16">
                    <path
                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="space-y-2">
        <div class="flex items-center justify-evenly">
            <x-label for="coin_5" value="Bs. {{ __('word.denomination.attribute.coin_5') }}"/>
            <input id="coi_5"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_5" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_5', $denomination->coin_5 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="coi_2" value="Bs. {{ __('word.denomination.attribute.coin_2') }}"/>
            <input id="coi_2"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_2" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_2', $denomination->coin_2 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="coi_1" value="Bs. {{ __('word.denomination.attribute.coin_1') }}"/>
            <input id="coi_1"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_1" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_1', $denomination->coin_1 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="coi_0_5" value="Bs. {{ __('word.denomination.attribute.coin_0_5') }}"/>
            <input id="coi_0_5"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 me-2 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_0_5" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_0_5', $denomination->coin_0_5 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="coi_0_2" value="Bs. {{ __('word.denomination.attribute.coin_0_2') }}"/>
            <input id="coi_0_2"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 me-2 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_0_2" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_0_2', $denomination->coin_0_2 ?? 0) }}"/>
        </div>
        <div class="flex items-center justify-evenly">
            <x-label for="coi_0_1" value="Bs. {{ __('word.denomination.attribute.coin_0_1') }}"/>
            <input id="coi_0_1"
                   class="bill-input-payment cursor-pointer text-center w-20 px-3 py-1 mt-1 me-2 font-bold text-slate-800 bg-slate-300 border border-slate-100 rounded-lg shadow-md hover:bg-slate-400 active:bg-slate-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2 transition-all ease-in-out focus:border-transparent"
                   type="text" name="coi_0_1" inputmode="numeric" autocomplete="one-time-code"
                   value="{{ old('coi_0_1', $denomination->coin_0_1 ?? 0) }}"/>
        </div>
    </div>
</div>
<div class="flex flex-row items-end mt-8 md:px-8 justify-evenly">
    <div class="flex flex-col text-center max-w-20 sm:max-w-96">
        <label for="payment_physical_cash_digital"
               class="text-gray-600 text-md mb-1">{{__('word.denomination.cash_digital')}}</label>
        <input
            type="text"
            readonly
            id="payment_physical_cash_digital"
            name="payment_physical_cash_digital"
            class="text-blue-600 text-center border-none outline-none select-none focus:ring-0 cursor-default"
            value="{{ old('payment_physical_cash_digital', 0.00) }}">
    </div>
    <div class="text-gray-500 text-xl self-center flex justify-center items-center">
        <a href="#" onclick="disabled_validation(this)" title="Habilitar guardado forzado">
            <div
                class="flex items-center justify-center w-10 h-10 bg-white border-2 border-gray-300 rounded-full hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-trash3"
                     viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                </svg>
            </div>
            <div
                class="flex items-center justify-center w-10 h-10 bg-white border-2 border-gray-300 rounded-full hover:bg-gray-200 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
                    <path
                        d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
                </svg>
            </div>
        </a>
        <input type="hidden" name="force_payment" value="0">
    </div>
    <div class="flex flex-col text-center max-w-20 sm:max-w-96">
        <label for="payment_physical_cash"
               class="text-gray-600 text-md mb-1">{{__('word.denomination.cash_income')}}</label>
        <input
            type="text"
            readonly
            id="payment_physical_cash"
            name="payment_physical_cash"
            class="text-center border-none outline-none select-none focus:ring-0 cursor-default"
            value="{{ old('payment_physical_cash', $denomination->physical_cash ?? 0.00) }}">
    </div>
</div>
<div class="flex flex-col items-end pt-4 px-4 md:px-8">
    <div class="flex flex-col text-center w-1/2">
        <label for="payment_digital_cash"
               class="text-gray-600 text-md mb-1 ">{{__('word.denomination.digital_income')}}</label>
        <input
            type="text"
            readonly
            id="payment_digital_cash"
            name="payment_digital_cash"
            class="text-center border-none outline-none select-none focus:ring-0 cursor-default"
            value="{{ old('payment_digital_cash', $denomination->digital_cash ?? 0.00) }}">
    </div>
</div>

<div class="space-y-6 px-0 sm:px-6 mt-4">
    <div
        class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-y-2 bg-white p-6 shadow-lg rounded-lg border border-gray-200">
        <div class="flex flex-row col-span-3">
            <label for="full" class="text-sm flex justify-start sm:justify-center items-center w-1/2">
                {{ __('word.denomination.attribute.total') }}
            </label>
            <input
                type="text"
                readonly
                id="full"
                name="full"
                class="outline-none border-none select-none focus:ring-0 text-md cursor-default text-center w-1/2"
                value="{{ old('full', $denomination->total ?? 0.00) }}">
        </div>
        <div class="flex flex-row col-span-3">
            <label for="payment" class="text-sm flex justify-center items-center w-1/2">
                {{ __('word.denomination.attribute.total_due') }}
            </label>
            <input
                type="text"
                readonly
                id="payment"
                name="payment"
                class="outline-none border-none select-none focus:ring-0 text-md cursor-default text-center w-1/2"
                value="{{ old('payment' ?? 0.00) }}">
        </div>
        <div class="flex flex-row col-span-3">
            <label for="state" id="payment_balance_label"
                   class="text-sm flex justify-center items-center w-1/2">{{ __('word.denomination.attribute.change') }}</label>
            <input
                type="text"
                readonly
                id="state"
                name="state"
                class="outline-none border-none select-none focus:ring-0 text-md cursor-default rounded-md font-extrabold text-center w-1/2"
                value="{{ old('state' ?? 0.00) }}">
        </div>

    </div>
</div>




