<div class="p-4 bg-gray-800 text-white rounded-lg shadow-md">
  <div class="text-xl font-bold text-center mb-4">BILLETAJE</div>
  <hr class="mb-4">

  <!-- Contenedor de columnas para billetes/monedas -->
  <div class="grid grid-cols-2 gap-4">
    <!-- Columna 1 -->
    <div class="space-y-2">

      <div class="flex items-center justify-evenly">
        <x-label for="bill_200" value="{{ __('word.denomination.attribute.bill_200') }}" />
        <x-input id="bill_200" data-denomination="200" class="pl-9 block mt-1 w-20" type="text" name="bill_200" value="{{ old('bill_200', $denomination->bill_200==0?'': $denomination->bill_200) }}" />
      </div>

      <div class="flex items-center justify-evenly">
        <x-label for="bill_100" value="{{ __('word.denomination.attribute.bill_100') }}" />
        <x-input id="bill_100" data-denomination="100" class="pl-9 block mt-1 w-20" type="text" name="bill_100" value="{{ old('bill_100', $denomination->bill_100==0?'': $denomination->bill_100) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="bill_50" value="{{ __('word.denomination.attribute.bill_50') }}" />
        <x-input id="bill_50" data-denomination="50" class="pl-9 block mt-1 w-20" type="text" name="bill_50" value="{{ old('bill_50', $denomination->bill_50==0?'': $denomination->bill_50) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="bill_20" value="{{ __('word.denomination.attribute.bill_20') }}" />
        <x-input id="bill_20" data-denomination="20" class="pl-9 block mt-1 w-20" type="text" name="bill_20" value="{{ old('bill_20', $denomination->bill_20==0?'': $denomination->bill_20) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="bill_10" value="{{ __('word.denomination.attribute.bill_10') }}" />
        <x-input id="bill_10" data-denomination="10" class="pl-9 block mt-1 w-20" type="text" name="bill_10" value="{{ old('bill_10', $denomination->bill_10==0?'': $denomination->bill_10) }}" />
      </div>
    </div>
    <!-- Columna 2 -->
    <div class="space-y-2">
      <div class="flex items-center justify-evenly">
        <x-label for="coin_5" value="{{ __('word.denomination.attribute.coin_5') }}" />
        <x-input id="coin_5" data-denomination="5" class="pl-9 block mt-1 w-20" type="text" name="coin_5" value="{{ old('coin_5', $denomination->coin_5==0?'': $denomination->coin_5) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="coin_2" value="{{ __('word.denomination.attribute.coin_2') }}" />
        <x-input id="coin_2" data-denomination="2" class="pl-9 block mt-1 w-20" type="text" name="coin_2" value="{{ old('coin_2', $denomination->coin_2==0?'': $denomination->coin_2) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="coin_1" value="{{ __('word.denomination.attribute.coin_1') }}" />
        <x-input id="coin_1" data-denomination="1" class="pl-9 block mt-1 w-20" type="text" name="coin_1" value="{{ old('coin_1', $denomination->coin_1==0?'': $denomination->coin_1) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="coin_0_5" value="{{ __('word.denomination.attribute.coin_0_5') }}" />
        <x-input id="coin_0_5" data-denomination="0.5" class="pl-9 block mt-1 w-20" type="text" name="coin_0_5" value="{{ old('coin_0_5', $denomination->coin_0_5==0?'': $denomination->coin_0_5) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="coin_0_2" value="{{ __('word.denomination.attribute.coin_0_2') }}" />
        <x-input id="coin_0_2" data-denomination="0.2" class="pl-9 block mt-1 w-20" type="text" name="coin_0_2" value="{{ old('coin_0_2', $denomination->coin_0_2==0?'': $denomination->coin_0_2) }}" />
      </div>
      <div class="flex items-center justify-evenly">
        <x-label for="coin_0_1" value="{{ __('word.denomination.attribute.coin_0_1') }}" />
        <x-input id="coin_0_1" data-denomination="0.1" class="pl-9 block mt-1 w-20" type="text" name="coin_0_1" value="{{ old('coin_0_1', $denomination->coin_0_1==0?'': $denomination->coin_0_1) }}" />
      </div>
    </div>
  </div>

  <!-- Totales y Cambio -->
  <div class="space-y-2 pt-4 px-8">
    <hr class="mb-4">
    <div class="flex items-center justify-between">
      <x-label for="total" class="select-none" value="{{ __('word.denomination.attribute.total') }}" />
      <input type="text" readonly id="total" name="total" class="w-28 p-2 bg-gray-600 border border-gray-600 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 select-none" value="{{ old('total', $denomination->total?? '') }}">
    </div>
    <div class="flex items-center justify-between">
      <x-label for="total_due" class="select-none" value="{{ __('word.denomination.attribute.total_due') }}" />
      <input type="text" disabled id="total_due" name="total_due" class=" w-28 p-2 bg-gray-600 border border-gray-600 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 select-none">
    </div>
    <div class="flex items-center justify-between">
      <x-label for="change" id="change_label" class="select-none" value="{{ __('word.denomination.attribute.change') }}" />
      <input type="text" disabled id="change" name="change" class="w-28 p-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 select-none ">
    </div>
  </div>
</div>