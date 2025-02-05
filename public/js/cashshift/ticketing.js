"use strict";
document.addEventListener("DOMContentLoaded", () => {
    update_price_cashshift();
    updateTotalandBalance();
});
const update_price_cashshift = () => {
    const charge = document.getElementById('charge');
    const price = parseFloat(document.getElementById('price').value) || 0;
    charge.value = (price).toFixed(2);
    updateTotalandBalance();
}
