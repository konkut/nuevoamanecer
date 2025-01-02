"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateCharge_paymentwithprice();
    updateTotalandBalance();
});
const updateCharge_paymentwithprice = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash = document.getElementById('physical_cash');
    const amount_input = document.querySelectorAll('.amount-input');
    const commission_input = document.querySelectorAll('.commission-input');
    let method_select = document.querySelectorAll('.method-select');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;

    method_select.forEach((method, index) => {
        const selected_amount = amount_input[index];
        const selected_commission = commission_input[index];
        let selected_method = method.options[method.selectedIndex];
        const amount_value = parseFloat(selected_amount.value) || 0;
        const commission_value = parseFloat(selected_commission.value) || 0;
        const name_select = selected_method.getAttribute('data-name');
        if (name_select === 'EFECTIVO') {
            total_physical += (amount_value + commission_value);
        }
        if (name_select !== 'EFECTIVO' && name_select !== 'None' ){
            total_digital += (amount_value + commission_value);
        }
        total_amount += (amount_value + commission_value);
    });
   // console.log('Total Cash:', total_physical);
   // console.log('Total Digital:', total_digital);
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
