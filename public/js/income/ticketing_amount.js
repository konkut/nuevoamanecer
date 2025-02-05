"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_amount();
    updateTotalandBalance();
});
const update_amount = (element = null) => {
    let amount_inputs = document.querySelectorAll('.amount-input');
    let commission_inputs = document.querySelectorAll('.commission-input');
    let service_selects = document.querySelectorAll('.service-select');
    let quantity_inputs = document.querySelectorAll('.quantity-input');
    let method_selects = document.querySelectorAll('.method-select');
    let charge = document.getElementById('charge');
    let digital_cash = document.getElementById('digital_cash');
    let physical_cash_digital = document.getElementById('physical_cash_digital');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    method_selects.forEach((item, index) => {
        let selected_service = service_selects[index].options[service_selects[index].selectedIndex];
        let selected_method = item.options[item.selectedIndex];
        let selected_amount = amount_inputs[index];
        let selected_commission = commission_inputs[index];
        let selected_quantity = quantity_inputs[index];
        if (element) {
            if (element.classList.contains('service-select')) {
                let amount_input = parseFloat(selected_service.getAttribute('data-price'));
                if (amount_input) selected_amount.value = amount_input.toFixed(2);
                let commission_input = parseFloat(selected_service.getAttribute('data-commission'));
                if (commission_input) selected_commission.value = commission_input.toFixed(2);
            }
        }
        let name = selected_method.getAttribute('data-name');
        let amount = parseFloat(selected_amount.value) || 0;

        const commission = parseFloat(selected_commission.value) || 0;
        let quantity = parseFloat(selected_quantity.value) || 0;
        if (name === 'EFECTIVO') total_physical += (amount  + commission) * (quantity);
        if (name !== 'EFECTIVO' && name !== 'None') total_digital += (amount + commission) * (quantity);
        total_amount += (amount + commission) * (quantity);
    });
    if (digital_cash) digital_cash.value = total_digital.toFixed(2);
    if (physical_cash_digital) physical_cash_digital.value = total_physical.toFixed(2);
    if (charge) charge.value = total_amount.toFixed(2);
    updateTotalandBalance();
}
