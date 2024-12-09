<div class="mt-4">
    <x-label for="observation" value="{{ __('word.payment.attribute.observation') }}" />
    <div class="relative">
        <i id="observation_icon" class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
        <x-input id="observation" class="pl-9 block mt-1 w-full" type="text" name="observation" value="{{ old('observation', $paymentwithprice->observation ?? '') }}" />
    </div>
</div>
<div id="dynamic-rows-container" class="flex flex-col space-y-4">
    <div class="flex flex-col md:flex-row md:space-x-4 row-template">
        <div class="mt-4 w-full md:w-1/2">
            <x-label for="name" value="{{ __('word.payment.attribute.name') }} *" />
            <div class="relative">
                <i id="name_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <x-input id="name" class="pl-9 pr-3 py-2 block mt-1 w-full" type="text" name="names[]" />
            </div>
        </div>

        <div class="mt-4 w-full md:w-1/2">
            <x-label for="amount" value="{{ __('word.payment.attribute.amount') }} *" />
            <div class="relative">
                <i id="amount_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <x-input id="amount" onkeyup="updateCharge_paymentwithprice()" class="amount-input pl-9 pr-3 py-2 block mt-1 w-full" type="text" name="amounts[]" value="{{ $paymentwithprice->amounts?? '' }}" />
            </div>
        </div>

        <div class="mt-4 w-full md:w-1/2">
            <x-label for="commission" value="{{ __('word.payment.attribute.commission') }}" />
            <div class="relative">
                <i id="commission_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <x-input id="commission" onkeyup="updateCharge_paymentwithprice()" class="amount-input pl-9 pr-3 py-2 block mt-1 w-full" type="text" name="commissions[]" value="{{ $paymentwithprice->commissions?? '' }}" />
            </div>
        </div>

        <div class="mt-4 w-full md:w-1/2">
            <x-label for="servicewithoutprice_uuid" value="{{ __('word.payment.attribute.servicewithoutprice_uuid') }} *" />
            <div class="relative">
                <i id="servicewithoutprice_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <select id="servicewithoutprice_uuid" onchange="updateCharge_paymentwithprice()" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="servicewithoutprice_uuids[]">
                    <option value="" disabled selected>{{ __('word.payment.select_service') }}</option>
                    @foreach($servicewithoutprices as $item)
                        <option value="{{ $item->servicewithoutprice_uuid }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 w-full md:w-1/2">
            <x-label for="transactionmethod_uuid" value="{{ __('word.payment.attribute.transactionmethod_uuid') }} *" />
            <div class="relative">
                <i id="transactionmethod_uuid_icon" class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#d1d5db]"></i>
                <select id="transactionmethod_uuid" class="border-t border-b border-[#d1d5db] pl-9 pr-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-400 focus:border-blue-400 w-full" name="transactionmethod_uuids[]">
                    <option value="" disabled selected>{{ __('word.payment.select_method') }}</option>
                    @foreach($transactionmethods as $item)
                        <option value="{{ $item->transactionmethod_uuid }}">
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col md:flex-row md:justify-evenly mt-6 space-y-4 md:space-y-0">
    <div class="flex justify-center">
        <!-- Botón para agregar fila -->
        <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
            <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
        </button>
    </div>

    <div class="flex justify-center">
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
        addRowButton.addEventListener('click', function () {
            const template = document.querySelector('.row-template');
            const newRow = template.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
            newRow.querySelectorAll('select').forEach(select => {
                select.value = '';
            });
            container.appendChild(newRow);
        });

        // Quitar la última fila
        removeRowButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.row-template');
            if (rows.length > 1) {
                rows[rows.length - 1].remove(); // Quita la última fila si hay más de una
            }
        });
    });

</script>
