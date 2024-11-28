"use strict";

(() => {
    // Obtener los elementos del formulario
    const totalInput = document.getElementById("total");
    const totalDueInput = document.getElementById("total_due");
    const changeInput = document.getElementById("change");
    const changeLabel = document.getElementById("change_label");
    const opening = document.getElementById("opening");

    // Inicializar valores predeterminados
    totalDueInput.value = "0.00";
    totalInput.value = "0.00";
    changeInput.value = "0.00";
    changeLabel.innerHTML = "SALDO EQUILIBRADO";

    // Inicializar denominaciones
    const denominationInputs = document.querySelectorAll(
        "#bill_200, #bill_100, #bill_50, #bill_20, #bill_10, #coin_5, #coin_2, #coin_1, #coin_0_5, #coin_0_2, #coin_0_1"
    );

    // Función para calcular el total de las denominaciones
    function calculateTotal() {
        let total = 0;

        denominationInputs.forEach((input) => {
            const value = parseFloat(input.value) || 0;
            const denomination = parseFloat(input.dataset.denomination) || 0; // Leer el valor del denominación del atributo data
            total += value * denomination;
        });

        totalInput.value = total.toFixed(2);
        updateTotalAndChange();
    }

    // Función para calcular el total a cobrar (total_due)
    function calculateTotalDue() {
        const openingValue = parseFloat(opening.value) || 0;
        totalDueInput.value = openingValue.toFixed(2);
        updateTotalAndChange();
    }

    // Función para actualizar el saldo y el cambio
    function updateTotalAndChange() {
        const totalDue = parseFloat(totalDueInput.value) || 0;
        const total = parseFloat(totalInput.value) || 0;
        const change = total - totalDue;

        changeInput.value = change.toFixed(2);
        updateChangeLabel(change);
    }

    // Función para actualizar la etiqueta de cambio
    function updateChangeLabel(change) {
        if (change < 0) {
            changeLabel.innerHTML = "SALDO FALTANTE";
            changeInput.classList.remove("bg-green-600");
            changeInput.classList.add("bg-red-600");
        } else if (change > 0) {
            changeLabel.innerHTML = "SALDO SOBRANTE";
            changeInput.classList.remove("bg-green-600");
            changeInput.classList.add("bg-red-600");
        } else {
            changeLabel.innerHTML = "SALDO EQUILIBRADO";
            changeInput.classList.remove("bg-red-600");
            changeInput.classList.add("bg-green-600");
        }
    }

    // Escuchar cambios en denominaciones
    denominationInputs.forEach((input) => {
        input.addEventListener("input", calculateTotal);
    });

    // Escuchar eventos de entrada en el campo "opening"
    opening.addEventListener("input", calculateTotalDue);

    // Inicializar cálculo inicial
    calculateTotal();
    calculateTotalDue();
})();
