document.addEventListener('input', (event) => {
    if (event.target.matches('#balance, #amount, #commission, #price, #stock, #account_number, #initial_balance, .debit-input, .credit-input, #cheque_number, #ufv, #usd')) {
        const input = event.target;
        const validRegex = /^-?\d*(\.\d{0,2})?$/;
        if (!validRegex.test(input.value)) {
            input.value = input.value.slice(0, -1);
        }
    }
});
