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
    let charge_selects = document.querySelectorAll('.charge-select');
    let payment_selects = document.querySelectorAll('.payment-select');
    let value_inputs = document.querySelectorAll('.value-input');
    let charge = document.getElementById('charge');
    let digital_cash = document.getElementById('digital_cash');
    let physical_cash_digital = document.getElementById('physical_cash_digital');
    let payment = document.getElementById('payment');
    let payment_digital_cash = document.getElementById('payment_digital_cash');
    let payment_physical_cash_digital = document.getElementById('payment_physical_cash_digital');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    let payment_amount = 0;
    let payment_digital = 0;
    let payment_physical = 0;
    charge_selects.forEach((item, index) => {
        let selected_payment = payment_selects[index].options[payment_selects[index].selectedIndex];
        let selected_charge = item.options[item.selectedIndex];
        let selected_amount = amount_inputs[index];
        let selected_commission = commission_inputs[index];
        let selected_quantity = quantity_inputs[index];
        let selected_value = value_inputs[index];
        if (selected_amount && selected_commission) {
            if (element) {
                if (element.classList.contains('service-select')) {
                    let key = Array.from(service_selects).indexOf(element);
                    let aux_service = service_selects[key].options[service_selects[key].selectedIndex];
                    let aux_service_amount = parseFloat(aux_service.getAttribute('data-price'));
                    let aux_amount = amount_inputs[key];
                    if (aux_service_amount) aux_amount.value = aux_service_amount.toFixed(2);
                    else aux_amount.value = "";
                    let aux_service_commission = parseFloat(aux_service.getAttribute('data-commission'));
                    let aux_commission = commission_inputs[key];
                    if (aux_service_commission) aux_commission.value = aux_service_commission.toFixed(2);
                    else aux_commission.value = "";
                }
            }
            if (element) {
                if (element.classList.contains('payment-select')) {
                    let key = Array.from(payment_selects).indexOf(element);
                    let selected_payment = payment_selects[key].options[payment_selects[key].selectedIndex];
                    let aux_value = value_inputs[key];
                    let aux_amount = amount_inputs[key];
                    aux_value.value = aux_amount.value;
                    if (selected_payment.getAttribute('data-name') == 'None') {
                        aux_value.value = "";
                    }
                }
            }
            let name = selected_charge.getAttribute('data-name');
            let label = selected_payment.getAttribute('data-name');

            let amount = parseFloat(selected_amount.value) || 0;
            let commission = parseFloat(selected_commission.value) || 0;
            let value = parseFloat(selected_value.value) || 0;
            let quantity = parseFloat(selected_quantity.value) || 0;
            if (name == true) total_physical += (amount + commission) * (quantity);
            if (name != true && name !== 'None') total_digital += (amount + commission) * (quantity);
            total_amount += (amount + commission) * (quantity);
            if (label == true) payment_physical += value;
            if (label != true && label !== 'None') payment_digital += value;
            payment_amount += value;
        }
    });
    if (digital_cash) digital_cash.value = total_digital.toFixed(2);
    if (physical_cash_digital) physical_cash_digital.value = total_physical.toFixed(2);
    if (charge) charge.value = total_amount.toFixed(2);
    if (payment_digital_cash) payment_digital_cash.value = payment_digital.toFixed(2);
    if (payment_physical_cash_digital) payment_physical_cash_digital.value = payment_physical.toFixed(2);
    if (payment) payment.value = payment_amount.toFixed(2);
    updateTotalandBalance();
    updatePaymentandBalance();
}
