"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateChargeFromCashcount();
    updateTotalandBalance();
});
const updateChargeFromCashcount = () => {
    const charge = document.getElementById('charge');
    const physical_balance = parseFloat(document.getElementById('physical_balance').value) || 0;
    charge.value = (physical_balance).toFixed(2);
    updateTotalandBalance();
}
