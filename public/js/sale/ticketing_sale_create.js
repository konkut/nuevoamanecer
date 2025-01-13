"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_sale_charge();
    updateTotalandBalance();
});
const update_sale_charge = () => {
    const charge = document.getElementById('charge');
    const digital_cash = document.getElementById('digital_cash');
    const physical_cash_digital = document.getElementById('physical_cash_digital');
    const product_select = document.querySelectorAll('.product-select');
    const method_select = document.querySelectorAll('.method-select');
    const quantities_input = document.querySelectorAll('.quantities-input');
    let total_amount = 0;
    let total_digital = 0;
    let total_physical = 0;
    method_select.forEach((method, index) => {
        const product = product_select[index];
        const selected_quantity = quantities_input[index];
        const selected_product = product.options[product.selectedIndex];
        const selected_method = method.options[method.selectedIndex];
        const quantity_value = parseFloat(selected_quantity.value) || 0;
        const price = parseFloat(selected_product.getAttribute('data-price')) || 0;
        let name_select = selected_method.getAttribute('data-name');
        if (name_select === 'EFECTIVO') {
            total_physical += (price * quantity_value);
        }
        if (name_select !== 'EFECTIVO' && name_select !== 'None' ){
            total_digital += (price * quantity_value);
        }
        total_amount += (price * quantity_value);
    });
    //console.log('Total Digital:', total_digital);
    //console.log('Total Cash:', total_physical);
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
