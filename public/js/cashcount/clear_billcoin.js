document.querySelectorAll('.denomination-cashcount').forEach(input => {
    input.value = (input.value == 0) ? "" : input.value;
});

let clear_billcoin_cashcount = (uuid) => {
    localStorage.removeItem(`cash_data_${uuid}`);
    window.location.reload();
}
