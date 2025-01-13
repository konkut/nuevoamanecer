"use strict";
const enable_seach_cash = (th, placeholder) => {
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
        filter_table_cash(Array.from(th.parentNode.children).indexOf(th), this.value);
    });
    input.addEventListener("blur", function () {
        th.innerHTML = originalContent;
    });
};
const filter_table_cash = (columnIndex, searchValue) => {
    const table = document.querySelector("#table_cash");
    let rows = table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        const cell = row.querySelectorAll("td")[columnIndex]; // Ajusta el índice para comenzar desde 0
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            row.style.display = textValue.toLowerCase().indexOf(searchValue.toLowerCase()) > -1 ? "" : "none";
        }
    });
};
const enable_seach_bank = (th, placeholder) => {
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
        filter_table_bank(Array.from(th.parentNode.children).indexOf(th), this.value);
    });
    input.addEventListener("blur", function () {
        th.innerHTML = originalContent;
    });
};
const filter_table_bank = (columnIndex, searchValue) => {
    const table = document.querySelector("#table_bank");
    let rows = table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        const cell = row.querySelectorAll("td")[columnIndex]; // Ajusta el índice para comenzar desde 0
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            row.style.display = textValue.toLowerCase().indexOf(searchValue.toLowerCase()) > -1 ? "" : "none";
        }
    });
};
