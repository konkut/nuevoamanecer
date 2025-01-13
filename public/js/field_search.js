"use strict";
const enableSearch = (th, placeholder) => {
    if (th.querySelector("input")) return;
    const originalContent = th.innerHTML;
    const container = document.createElement("div");
    container.className = "flex justify-center items-center w-full";
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Buscar " + placeholder;
    input.className = "border-0 focus:outline-none rounded-full px-2 py-1 w-24 text-xs text-gray-700";
    input.style.textAlign = "center";
    th.innerHTML = "";
    container.appendChild(input);
    th.appendChild(container);
    input.focus();
    input.addEventListener("keyup", function () {
        filterTable(Array.from(th.parentNode.children).indexOf(th), this.value);
    });
    input.addEventListener("blur", function () {
        th.innerHTML = originalContent;
    });
};
const filterTable = (columnIndex, searchValue) => {
    const table = document.querySelector("table");
    let rows = table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        const cell = row.querySelectorAll("td")[columnIndex]; // Ajusta el índice para comenzar desde 0
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            row.style.display = textValue.toLowerCase().indexOf(searchValue.toLowerCase()) > -1 ? "" : "none";
        }
    });
};
