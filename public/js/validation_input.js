document.addEventListener('input', (event) => {
    if (event.target.matches('#balance, #amount, #commission, #price, #stock, #account_number, #initial_balance')) {
        const input = event.target;
        const validRegex = /^-?\d*(\.\d{0,2})?$/;
        if (!validRegex.test(input.value)) {
            input.value = input.value.slice(0, -1);
        }
    }
});
