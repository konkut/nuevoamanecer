<div>
  <x-label for="code" value="{{ __('word.incomefromtransfer.attribute.code') }} *" />
  <div class="relative">
    <i id="code_icon" class="bi bi-tag absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="code" class="pl-9 block mt-1 w-full" type="text" name="code" value="{{ old('code', $incomefromtransfer->code?? '') }}" />
  </div>
</div>

<div class="mt-4">
  <x-label for="observation" value="{{ __('word.incomefromtransfer.attribute.observation') }}" />
  <div class="relative">
    <i id="observation_icon" class="bi-info-circle absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
    <x-input id="observation" class="pl-9 block mt-1 w-full" type="text" name="observation" value="{{ old('observation', $incomefromtransfer->observation?? '') }}" />
  </div>
</div>
<div id="services-url" data-url="{{ route('servicesnew.get') }}"></div>
<div id="container">
  <div class="flex flex-row justify-evenly gap-4 input-row items-end">
    <!-- Campo de Amount -->
    <div class="mt-4">
      <x-label for="amount" value="{{ __('word.incomefromtransfer.attribute.amount') }} *" />
      <div class="relative">
        <i class="bi bi-cash absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
        <x-input
          class="pl-9 block mt-1 w-full amount-input"
          type="text"
          name="amounts[]"
          value="{{ old('amounts.0', $amounts[0] ?? '') }}" />
      </div>
    </div>

    <!-- Campo de Commission -->
    <div class="mt-4">
      <x-label for="commission" value="{{ __('word.incomefromtransfer.attribute.commission') }}" />
      <div class="relative">
        <i class="bi bi-percent absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
        <x-input
          class="pl-9 block mt-1 w-full commission-input"
          type="text"
          name="commissions[]"
          value="{{ old('commissions.0', $commissions[0] ?? '') }}" />
      </div>
    </div>

    <!-- Campo de Service UUID -->
    <div class="mt-4">
      <x-label for="service_uuid" value="{{ __('word.incomefromtransfer.attribute.service_uuid') }} *" />
      <div class="relative">
        <i class="bi bi-list-ul absolute top-1.5 left-2 text-[1.3em] text-[#374151]"></i>
        <select
          class="pl-9 mt-1 pr-3 py-2 bg-[#111827] text-white border border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-[#2563eb] focus:border-[#2563eb] w-full service-select"
          name="service_uuids[]">
          <option value="" disabled selected>{{ __('word.incomefromtransfer.select_service') }}</option>
          @foreach ($services as $service)
          <option value="{{ $service->service_uuid }}"
            {{ old('service_uuids.0', $service_uuids[0] ?? '') == $service->service_uuid ? 'selected' : '' }}>
            {{ $service->name }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</div>

<div class="flex flex-row justify-evenly">
  <div class="flex justify-center mt-6">
    <!-- Botón para agregar fila -->
    <button type="button" id="add-row" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded shadow-lg">
      <i class="bi bi-plus mr-2"></i>{{ __('Agregar Fila') }}
    </button>
  </div>

  <div class="flex justify-center mt-6">
    <!-- Botón para quitar fila -->
    <button type="button" id="remove-row" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded shadow-lg">
      <i class="bi bi-dash mr-2"></i>{{ __('Quitar Fila') }}
    </button>
  </div>
</div>