
document.querySelectorAll('.bill-input').forEach(input => {
    input.value = (input.value) == 0 ? "" : input.value;
    input.addEventListener('keyup', (e) => {
        updateTotalandBalance();
    });
});
