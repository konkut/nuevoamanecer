"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateCharge_expense();
    updateTotalandBalance();
});
const updateCharge_expense = () => {
    const charge = document.getElementById('charge');
    const input = document.querySelector('#amount');
    let totalAmount =  parseFloat(input.value) || 0;
    if (charge) {
        charge.value = totalAmount.toFixed(2) ;
    }
    updateTotalandBalance();
}
