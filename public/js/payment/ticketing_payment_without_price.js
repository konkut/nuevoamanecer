"use strict";
document.addEventListener("DOMContentLoaded", () => {
    updateCharge_paymentwithoutprice();
    updateTotalandBalance();
});
const updateCharge_paymentwithoutprice = () => {
    const charge = document.getElementById('charge');
        const allSelects = document.querySelectorAll('.service-select');
        let totalAmount = 0;
        // Recorre todos los selects y suma sus valores
        allSelects.forEach((select) => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.hasAttribute('data-amount') && selectedOption.hasAttribute('data-commission')) {
                const amount = parseFloat(selectedOption.getAttribute('data-amount'));
                const commission = parseFloat(selectedOption.getAttribute('data-commission'));
                totalAmount += amount + commission;
            }
        });
        if (charge) {
            charge.value = totalAmount.toFixed(2);
        }
    updateTotalandBalance();
}
