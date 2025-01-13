"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_input();
    updateTotalandBalance();
});
const update_input = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash_digital = document.getElementById('physical_cash_digital');
    const method_select = document.querySelectorAll('.method-select');
    const quantity_input = document.querySelectorAll('.quantity-input');
    let amount_input = document.querySelectorAll('.amount-input');
    let commission_input = document.querySelectorAll('.commission-input');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    method_select.forEach((method, index) => {
        const selected_method = method.options[method.selectedIndex];
        const selected_amount = amount_input[index];
        const selected_commission = commission_input[index];
        const selected_quantity = quantity_input[index];
        const amount = parseFloat(selected_amount.value) || 0;
        const commission = parseFloat(selected_commission.value) || 0;
        const quantity = parseFloat(selected_quantity.value) || 1;
        const name_select = selected_method.getAttribute('data-name');
        if (name_select === 'EFECTIVO') {
            total_physical += (amount  + commission) * quantity;
        }
        if (name_select !== 'EFECTIVO' && name_select !== 'None' ){
            total_digital += (amount + commission) * quantity;
        }
        total_amount += (amount + commission) * quantity;
    });
    if (digital_cash) {
        digital_cash.value = total_digital.toFixed(2);
    }
    if (physical_cash_digital) {
        physical_cash_digital.value = total_physical.toFixed(2);
    }
    if (charge) {
        charge.value = total_amount.toFixed(2);
    }
    updateTotalandBalance();
}
