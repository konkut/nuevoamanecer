<div class="mt-4">
    <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}" />
    <div class="relative">
        <i id="observation_icon" class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="pl-9 block mt-1 w-full" type="text" name="observation" value="{{ old('observation', $paymentwithoutprice->observation?? '') }}" />
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    <!-- Generar dinámicamente las filas basadas en las relaciones -->
    @foreach ($services as $index => $serviceUuid)
        <div class="flex flex-col md:flex-row md:space-x-4 row-template">
            <div class="mt-4 w-full sm:w-1/2">
                <x-label for="servicewithprice_uuid" value="{{ __('word.payment.attribute.servicewithprice_uuid') }} *" />
                <div class="relative">
                    <i id="servicewithprice_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                    <select id="servicewithprice_uuid" onchange="updateCharge_paymentwithoutprice()" class="service-select border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="servicewithprice_uuids[]">
                        <option value="" disabled>{{ __('word.payment.select_service') }}</option>
                        @foreach($servicewithprices as $item)
                            <option value="{{ $item->servicewithprice_uuid }}" data-amount="{{ $item->amount }}" data-commission="{{ $item->commission }}"
                                {{ $item->servicewithprice_uuid === $serviceUuid ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 w-full sm:w-1/2">
                <x-label for="transactionmethod_uuid" value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *" />
                <div class="relative">
                    <i id="transactionmethod_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                    <select id="transactionmethod_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="transactionmethod_uuids[]">
                        <option value="" disabled>{{ __('word.payment.select_method') }}</option>
                        @foreach($transactionmethods as $item)
                            <option value="{{ $item->transactionmethod_uuid }}"
                                {{ isset($methods[$index]) && $item->transactionmethod_uuid === $methods[$index] ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="flex flex-wrap justify-evenly mt-6 space-y-4 sm:space-y-0">
    <div class="flex justify-center w-full sm:w-auto">
        <!-- Botón para agregar fila -->
        <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
            <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
        </button>
    </div>

    <div class="flex justify-center w-full sm:w-auto">
        <!-- Botón para quitar fila -->
        <button type="button" id="remove-row" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
            <i class="bi bi-dash mr-2"></i>{{ __('Quitar Fila') }}
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('dynamic-rows-container');
        const addRowButton = document.getElementById('add-row');
        const removeRowButton = document.getElementById('remove-row');

        // Agregar una nueva fila
        addRowButton.addEventListener('click', function () {
            const template = document.querySelector('.row-template');
            const newRow = template.cloneNode(true);
            newRow.querySelectorAll('select').forEach(select => select.value = ''); // Reinicia los selects
            container.appendChild(newRow);
        });

        // Quitar la última fila
        removeRowButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.row-template');
            if (rows.length > 1) {
                rows[rows.length - 1].remove(); // Quita la última fila
            }
        });
    });
</script>
