"use strict";
document.addEventListener("DOMContentLoaded", () => {
    updateCharge_paymentwithoutprice();
    updateTotalandBalance();
});
const updateCharge_paymentwithoutprice = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash = document.getElementById('physical_cash');
    const service_select = document.querySelectorAll('.service-select');
    const method_select = document.querySelectorAll('.method-select');
    const quantities_input = document.querySelectorAll('.quantities-input');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    method_select.forEach((method, index) => {
        const service = service_select[index];
        const selected_service = service.options[service.selectedIndex];
        const selected_method = method.options[method.selectedIndex];
        const selected_quantity = quantities_input[index];
        const quantity_value = parseFloat(selected_quantity.value) || 0;
        const amount = parseFloat(selected_service.getAttribute('data-amount')) || 0;
        const commission = parseFloat(selected_service.getAttribute('data-commission')) || 0;
        const name_select = selected_method.getAttribute('data-name');
        if (name_select === 'EFECTIVO') {
            total_physical += (amount + commission)*quantity_value;
        }
        if (name_select !== 'EFECTIVO' && name_select !== 'None' ){
            total_digital += (amount + commission)*quantity_value;
        }
        total_amount += (amount + commission)*quantity_value;
    });
   // console.log('Total Digital:', total_digital);
    //console.log('Total Cash:', total_physical);
    if (digital_cash) {
        digital_cash.value = total_digital;
    }
    if (physical_cash) {
        physical_cash.value = total_physical;
    }
    if (charge) {
        charge.value = total_amount.toFixed(2);
    }
    updateTotalandBalance();
}
