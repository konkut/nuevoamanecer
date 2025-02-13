"use strict";

document.addEventListener("DOMContentLoaded", () => {
    update_charge_expense();
    updateTotalandBalance();
});
const update_charge_expense = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash_digital = document.getElementById('physical_cash_digital');
    const amount = document.querySelector('#amount');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    const charge_select = document.querySelector('.charge-select');
    const selected_charge = charge_select.options[charge_select.selectedIndex];
    let name_select = selected_charge.getAttribute('data-name');
    if (name_select == true) total_physical = parseFloat(amount.value) || 0;
    if (name_select != true && name_select !== 'None' ) total_digital = parseFloat(amount.value) || 0;
    total_amount = parseFloat(amount.value) || 0;
    if (digital_cash) digital_cash.value = total_digital.toFixed(2);;
    if (physical_cash_digital) physical_cash_digital.value = total_physical.toFixed(2);
    if (charge) charge.value = total_amount.toFixed(2) ;
    updateTotalandBalance();
}
