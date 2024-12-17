const userAgent = navigator.userAgent || navigator.vendor || window.opera;
if (/android/i.test(userAgent)) {
    document.querySelectorAll('.bill-input').forEach(input => {
        input.removeAttribute("readonly");
        input.value = (input.value) == 0 ? "" : input.value;
        input.addEventListener('keyup', (e) => {
            updateTotalandBalance();
        });
    });
} else {
    document.querySelectorAll('.bill-input').forEach(input => {
        input.addEventListener('mousedown', (e) => {
            let currentValue = parseInt(input.value) || 0;
            if (e.button === 0) {
                currentValue += 1;
            } else if (e.button === 2) {
                currentValue -= 1;
                e.preventDefault();
            }
            input.value = currentValue;
            updateTotalandBalance()
        });
        input.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
    });
}
//if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {}
