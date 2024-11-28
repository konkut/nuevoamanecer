"use strict";

(() => {
    let code_icon = document.getElementById("code_icon");
    let amount_icon = document.getElementById("amount_icon");
    let commission_icon = document.getElementById("commission_icon");
    let observation_icon = document.getElementById("observation_icon");
    let code = document.getElementById("code");

    /*FOCUS AND BLUR ICON*/
    code_icon.style.color = "#2563eb";
    code.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#code")) {
                code_icon.style.color = "#2563eb";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#2563eb";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#2563eb";
            } else if (e.target.matches("#observation")) {
                observation_icon.style.color = "#2563eb";
            } 
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#code")) {
                code_icon.style.color = "#374151";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#374151";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#374151";
            } else if (e.target.matches("#observation")) {
                observation_icon.style.color = "#374151";
            } 
        },
        true
    );
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("container");
    const addRowBtn = document.getElementById("add-row");
    const removeRowBtn = document.getElementById("remove-row");
    const servicesUrl = document
        .getElementById("services-url")
        .getAttribute("data-url");

    function loadServices() {
        fetch(servicesUrl)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
            })
            .catch((error) =>
                console.error("Error al cargar servicios:", error)
            );
    }

    loadServices();

    // Agregar una nueva fila
    addRowBtn.addEventListener("click", function () {
        const rows = document.querySelectorAll(".input-row");
        const lastRow = rows[rows.length - 1];
        const newRow = lastRow.cloneNode(true);

        // Limpiar valores en los inputs de la nueva fila
        newRow.querySelector(".amount-input").value = "";
        newRow.querySelector(".commission-input").value = "";
        newRow.querySelector(".service-select").selectedIndex = 0;

        // Agregar la nueva fila al contenedor
        container.appendChild(newRow);
    });

    // Eliminar la última fila
    removeRowBtn.addEventListener("click", function () {
        const rows = document.querySelectorAll(".input-row");
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
        }
    });

    // Enviar datos del formulario al servidor con AJAX
    function sendFormDataToServer() {
        const rows = document.querySelectorAll(".input-row");
        const formData = new FormData();

        rows.forEach((row, index) => {
            const amount = row.querySelector(".amount-input").value;
            const commission = row.querySelector(".commission-input").value;
            const service_uuid = row.querySelector(".service-select").value;

            formData.append(`amounts[${index}]`, amount);
            formData.append(`commissions[${index}]`, commission);
            formData.append(`service_uuids[${index}]`, service_uuid);
        });

        fetch("/ruta/a/tu/controlador", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                console.log("Datos enviados exitosamente:", data);
            })
            .catch((error) => {
                console.error("Error al enviar datos al servidor:", error);
            });
    }

    // Enviar los datos cuando el formulario se envíe
    const form = document.querySelector("form"); // Asegúrate de que el formulario esté bien identificado
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir el envío normal del formulario
        sendFormDataToServer(); // Enviar los datos por AJAX
    });
});




})();
