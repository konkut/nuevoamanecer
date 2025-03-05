"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_amount();
    updateTotalandBalance();
});
const update_amount = (element = null) => {
    let amount_inputs = document.querySelectorAll('.amount-input');
    let service_selects = document.querySelectorAll('.service-select');
    let charge_selects = document.querySelectorAll('.charge-select');
    let charge = document.getElementById('charge');
    let digital_cash = document.getElementById('digital_cash');
    let physical_cash_digital = document.getElementById('physical_cash_digital');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    charge_selects.forEach((item, index) => {
        let selected_charge = item.options[item.selectedIndex];
        let selected_amount = amount_inputs[index];
        if (selected_amount) {
            if (element) {
                if (element.classList.contains('service-select')) {
                    let key = Array.from(service_selects).indexOf(element);
                    let aux_service = service_selects[key].options[service_selects[key].selectedIndex];
                    let aux_service_amount = parseFloat(aux_service.getAttribute('data-price'));
                    let aux_amount = amount_inputs[key];
                    if (aux_service_amount) aux_amount.value = aux_service_amount.toFixed(2);
                    else aux_amount.value = "";
                }
            }
            let name = selected_charge.getAttribute('data-name');
            let amount = parseFloat(selected_amount.value) || 0;
            if (name == true) total_physical += amount;
            if (name != true && name !== 'None') total_digital += amount;
            total_amount += amount;
        }
    });
    if (digital_cash) digital_cash.value = total_digital.toFixed(2);
    if (physical_cash_digital) physical_cash_digital.value = total_physical.toFixed(2);
    if (charge) charge.value = total_amount.toFixed(2);
    updateTotalandBalance();
}
