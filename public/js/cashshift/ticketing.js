"use strict";
document.addEventListener("DOMContentLoaded", () => {
    updateChargeFromCashshift();
    updateTotalandBalance();
});
const updateChargeFromCashshift = () => {
    const charge = document.getElementById('charge');
    const initial_balance = parseFloat(document.getElementById('initial_balance').value) || 0;
    charge.value = (initial_balance).toFixed(2);
    updateTotalandBalance();
}
