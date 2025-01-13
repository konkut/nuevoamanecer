"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_amount();
    updateTotalandBalance();
});
const update_amount = () => {
    let amount_inputs = document.querySelectorAll('.amount-input');
    let commission_inputs = document.querySelectorAll('.commission-input');
    let service_selects = document.querySelectorAll('.service-select');
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash_digital = document.getElementById('physical_cash_digital');
    const method_selects = document.querySelectorAll('.method-select');
    const quantity_inputs = document.querySelectorAll('.quantity-input');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    service_selects.forEach((method, index) => {
        const service = method.options[method.selectedIndex];
        const method_aux = method_selects[index];
        const method_item = method_aux.options[method_aux.selectedIndex];
        const amount_input = amount_inputs[index];
        const commission_input = commission_inputs[index];
        const quantity_input = quantity_inputs[index];
        const name = method_item.getAttribute('data-name');
        const amount = parseFloat(amount_input.value) || 0;
        const commission = parseFloat(commission_input.value) || 0;
        const quantity = parseFloat(quantity_input.value) || 1;
        if (name === 'EFECTIVO') {
            total_physical += (amount  + commission) * (quantity);
        }
        if (name !== 'EFECTIVO' && name !== 'None' ){
            total_digital += (amount + commission) * (quantity);
        }
        total_amount += (amount + commission) * (quantity);
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
