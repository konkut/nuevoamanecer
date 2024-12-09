"use strict";

document.addEventListener("DOMContentLoaded", () => {
    updateCharge_paymentwithprice();
    updateTotalandBalance();
});
const updateCharge_paymentwithprice = () => {
    const charge = document.getElementById('charge');
    const allInputs = document.querySelectorAll('.amount-input');
    let totalAmount = 0;
    allInputs.forEach((item) => {
        const value = parseFloat(item.value) || 0;
        totalAmount += value;
    });
    if (charge) {
        charge.value = totalAmount.toFixed(2) ;
    }

    updateTotalandBalance();
}
