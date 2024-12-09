<div class="p-4 rounded-lg shadow-md">
    <div class="text-xl font-bold text-center mb-4">BILLETAJE</div>
    <hr class="mb-4">

    <!-- Contenedor de columnas para billetes/monedas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
        <!-- Columna 1 -->
        <div class="space-y-2">

            <div class="flex items-center justify-evenly">
                <x-label for="bill_200" value="Bs. {{ __('word.denomination.attribute.bill_200') }}" />
                <x-input id="bill_200" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="bill_200" value="{{ old('bill_200', $denomination->bill_200==0?'': $denomination->bill_200) }}" />
            </div>

            <div class="flex items-center justify-evenly">
                <x-label for="bill_100" value="Bs. {{ __('word.denomination.attribute.bill_100') }}" />
                <x-input id="bill_100" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="bill_100" value="{{ old('bill_100', $denomination->bill_100==0?'': $denomination->bill_100) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="bill_50" value="Bs. {{ __('word.denomination.attribute.bill_50') }}" />
                <x-input id="bill_50" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="bill_50" value="{{ old('bill_50', $denomination->bill_50==0?'': $denomination->bill_50) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="bill_20" value="Bs. {{ __('word.denomination.attribute.bill_20') }}" />
                <x-input id="bill_20" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="bill_20" value="{{ old('bill_20', $denomination->bill_20==0?'': $denomination->bill_20) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="bill_10" value="Bs. {{ __('word.denomination.attribute.bill_10') }}" />
                <x-input id="bill_10" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="bill_10" value="{{ old('bill_10', $denomination->bill_10==0?'': $denomination->bill_10) }}" />
            </div>
        </div>

        <!-- Columna 2 -->
        <div class="space-y-2">
            <div class="flex items-center justify-evenly">
                <x-label for="coin_5" value="Bs. {{ __('word.denomination.attribute.coin_5') }}" />
                <x-input id="coin_5" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_5" value="{{ old('coin_5', $denomination->coin_5==0?'': $denomination->coin_5) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="coin_2" value="Bs. {{ __('word.denomination.attribute.coin_2') }}" />
                <x-input id="coin_2" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_2" value="{{ old('coin_2', $denomination->coin_2==0?'': $denomination->coin_2) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="coin_1" value="Bs. {{ __('word.denomination.attribute.coin_1') }}" />
                <x-input id="coin_1" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_1" value="{{ old('coin_1', $denomination->coin_1==0?'': $denomination->coin_1) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="coin_0_5" value="Bs. {{ __('word.denomination.attribute.coin_0_5') }}" />
                <x-input id="coin_0_5" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_0_5" value="{{ old('coin_0_5', $denomination->coin_0_5==0?'': $denomination->coin_0_5) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="coin_0_2" value="Bs. {{ __('word.denomination.attribute.coin_0_2') }}" />
                <x-input id="coin_0_2" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_0_2" value="{{ old('coin_0_2', $denomination->coin_0_2==0?'': $denomination->coin_0_2) }}" />
            </div>
            <div class="flex items-center justify-evenly">
                <x-label for="coin_0_1" value="Bs. {{ __('word.denomination.attribute.coin_0_1') }}" />
                <x-input id="coin_0_1" onkeyup="updateTotalandBalance()" class="text-center mt-1 w-full sm:w-20" type="text" name="coin_0_1" value="{{ old('coin_0_1', $denomination->coin_0_1==0?'': $denomination->coin_0_1) }}" />
            </div>
        </div>
    </div>

    <!-- Totales y Cambio -->
    <div class="space-y-2 pt-4 px-8">
        <hr class="mb-4">
        <div class="flex items-center justify-between">
            <x-label for="total" class="select-none" value="{{ __('word.denomination.attribute.total') }}" />
            <input
                type="text"
                readonly
                id="total"
                name="total"
                class="w-28 p-2 border-none outline-none select-none focus:ring-0 text-center  text-xl"
                value="{{ old('total', $denomination->total ?? '0.00') }}">
        </div>
        <div class="flex items-center justify-between">
            <x-label for="charge" class="select-none" value="{{ __('word.denomination.attribute.total_due') }}" />
            <input
                type="text"
                id="charge"
                name="charge"
                class="w-28 p-2 border-none outline-none select-none focus:ring-0 text-center text-xl"
                value="{{ old('charge' ?? '0.00') }}">
        </div>
        <div class="flex items-center justify-between">
            <x-label for="balance" id="balance_label" class="select-none" value="{{ __('word.denomination.attribute.change') }}" />
            <input
                type="text"
                id="balance"
                name="balance"
                class="w-28 p-2 border-none outline-none select-none focus:ring-0 text-center rounded-md font-extrabold text-xl"
                value="{{ old('balance' ?? '0.00') }}">
        </div>
    </div>
</div>
