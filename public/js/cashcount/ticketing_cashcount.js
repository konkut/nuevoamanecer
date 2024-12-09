"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateCharge_cashcount();
    updateTotalandBalance();
});
const updateCharge_cashcount = () => {
    const charge = document.getElementById('charge');
    const opening = parseFloat(document.getElementById('opening').value) || 0;
    charge.value = (opening).toFixed(2);
    updateTotalandBalance();
}
