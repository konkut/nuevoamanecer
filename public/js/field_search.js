"use strict";

/*SEARCH TABLE LIST */
const enableSearch = (th, placeholder) => {
    if (th.querySelector("input")) return;
    // Guardar el contenido original
    const originalContent = th.innerHTML;
    // Crear contenedor para controlar el tamaño del input
    const container = document.createElement("div");
    container.className = "flex justify-center items-center w-full";
    // Crear input de búsqueda con un ancho fijo y estilo
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Buscar " + placeholder;
    input.className =
        "border border-gray-300 rounded-full px-2 py-1 w-24 text-xs text-gray-700 focus:ring-2 focus:ring-blue-400";
    input.style.textAlign = "center";
    // Reemplazar contenido del encabezado por el contenedor con el input
    th.innerHTML = ""; // Limpia el contenido
    container.appendChild(input);
    th.appendChild(container);
    input.focus(); // Enfoca el input para buscar de inmediato
    // Agregar evento para filtrar al escribir
    input.addEventListener("keyup", function () {
        filterTable(Array.from(th.parentNode.children).indexOf(th), this.value);
    });
    // Al perder el foco, restaurar el contenido original
    input.addEventListener("blur", function () {
        th.innerHTML = originalContent;
    });
};

// SEARCH
const filterTable = (columnIndex, searchValue) => {
    const table = document.querySelector("table");
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        const cell = row.querySelectorAll("td")[columnIndex - 1]; // Ajusta el índice para comenzar desde 0
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            row.style.display =
                textValue.toLowerCase().indexOf(searchValue.toLowerCase()) > -1
                    ? ""
                    : "none";
        }
    });
};