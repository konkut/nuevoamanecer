<div class="bg-white shadow-md rounded-lg w-full max-w-2xl p-6">
    <!-- Navegación superior -->
    <div class="flex border-b mb-4">
        <button
            id="link-with-money"
            onclick="showTab('tab-payments-with-money')"
            class="w-1/2 text-center py-2 border-b-2 border-indigo-500 text-indigo-500 font-semibold transition">
            Pagos con Dinero
        </button>
        <button
            id="link-without-money"
            onclick="showTab('tab-payments-without-money')"
            class="w-1/2 text-center py-2 border-b-2 border-transparent text-gray-500 hover:border-gray-300 transition">
            Pagos sin Dinero
        </button>
    </div>

    <!-- Contenido de las pestañas -->
    <div id="tab-payments-with-money" class="block">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Pagos con Dinero</h2>
        <p class="text-gray-600">Aquí se muestra el contenido relacionado con los pagos que incluyen dinero.</p>
    </div>
    <div id="tab-payments-without-money" class="hidden">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Pagos sin Dinero</h2>
        <p class="text-gray-600">Aquí se muestra el contenido relacionado con los pagos que no incluyen dinero.</p>
    </div>
</div>
<script>
    // Función para mostrar el contenido correspondiente
    function showTab(tabId) {
        // Ocultar todos los divs
        document.getElementById("tab-payments-with-money").classList.add("hidden");
        document.getElementById("tab-payments-without-money").classList.add("hidden");

        // Mostrar el div seleccionado
        document.getElementById(tabId).classList.remove("hidden");

        // Actualizar la clase activa en los enlaces
        document.getElementById("link-with-money").classList.remove("border-indigo-500", "text-indigo-500");
        document.getElementById("link-without-money").classList.remove("border-indigo-500", "text-indigo-500");
        document.getElementById(tabId === "tab-payments-with-money" ? "link-with-money" : "link-without-money")
            .classList.add("border-indigo-500", "text-indigo-500");
    }
</script>
