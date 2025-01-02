"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateCharge_expense();
    updateTotalandBalance();
});
const updateCharge_expense = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash = document.getElementById('physical_cash');
    const amount = document.querySelector('#amount');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    const method_select = document.querySelector('.method-select');
    const selected_method = method_select.options[method_select.selectedIndex];
    let name_select = selected_method.getAttribute('data-name');
    if (name_select === 'EFECTIVO') {
        total_physical = parseFloat(amount.value) || 0;
    }
    if (name_select !== 'EFECTIVO' && name_select !== 'None' ){
        total_digital = parseFloat(amount.value) || 0;
    }
    total_amount = parseFloat(amount.value) || 0;
    if (digital_cash) {
        digital_cash.value = total_digital;
    }
    if (physical_cash) {
        physical_cash.value = total_physical;
    }
    if (charge) {
        charge.value = total_amount.toFixed(2) ;
    }
    updateTotalandBalance();
}
