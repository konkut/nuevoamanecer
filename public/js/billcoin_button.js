document.querySelectorAll('.bill-input').forEach(input => {
    input.value = (input.value) == 0 ? "" : input.value;
    input.addEventListener('keyup', (e) => {
        updateTotalandBalance();
    });
});
let disabled_validation = (element) => {
    element.firstElementChild.classList.toggle("hidden");
    element.lastElementChild.classList.toggle("hidden");
    const title = element.getAttribute("title") === "Habilitar guardado forzado"
        ? "Deshabilitar guardado forzado"
        : "Habilitar guardado forzado";
    element.setAttribute("title", title);
    if (element.lastElementChild.classList.contains('hidden')) element.nextElementSibling.value = 0;
    if (element.firstElementChild.classList.contains('hidden')) element.nextElementSibling.value = 1;
};
let clear_billcoin = (element) => {
    let inputs = document.querySelectorAll('.bill-input');
    inputs.forEach((method, index) => {
        inputs[index].value = null;
    });
    updateTotalandBalance();
}
