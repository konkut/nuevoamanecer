const updatePaymentandBalance = () => {
    let full = document.getElementById("full");
    let payment = document.getElementById("payment");
    let state = document.getElementById("state");
    document.addEventListener('input', (event) => {
        if (event.target.matches('#bil_200, #bil_100, #bil_50, #bil_20, #bil_10, #coi_5, #coi_2, #coi_1, #coi_0_5, #coi_0_2, #coi_0_1, .value-input')) {
            const input = event.target;
            const validRegex = /^-?\d*(\.\d{0,2})?$/;
            if (!validRegex.test(input.value)) {
                input.value = input.value.slice(0, -1);
            }
        }
    });
    let count_bill_200 = parseFloat(document.getElementById("bil_200").value) || 0;
    let count_bill_100 = parseFloat(document.getElementById("bil_100").value) || 0;
    let count_bill_50 = parseFloat(document.getElementById("bil_50").value) || 0;
    let count_bill_20 = parseFloat(document.getElementById("bil_20").value) || 0;
    let count_bill_10 = parseFloat(document.getElementById("bil_10").value) || 0;
    let count_coin_5 = parseFloat(document.getElementById("coi_5").value) || 0;
    let count_coin_2 = parseFloat(document.getElementById("coi_2").value) || 0;
    let count_coin_1 = parseFloat(document.getElementById("coi_1").value) || 0;
    let count_coin_0_5 = parseFloat(document.getElementById("coi_0_5").value) || 0;
    let count_coin_0_2 = parseFloat(document.getElementById("coi_0_2").value) || 0;
    let count_coin_0_1 = parseFloat(document.getElementById("coi_0_1").value) || 0;
    let input_digital = document.getElementById('payment_digital_cash');
    let digital_cash = input_digital ? parseFloat(input_digital.value) || 0 : 0;
    let input_physical = document.getElementById('payment_physical_cash');
    let physical_cash = (
        count_bill_200 * 200 +
        count_bill_100 * 100 +
        count_bill_50 * 50 +
        count_bill_20 * 20 +
        count_bill_10 * 10 +
        count_coin_5 * 5 +
        count_coin_2 * 2 +
        count_coin_1 * 1 +
        count_coin_0_5 * 0.5 +
        count_coin_0_2 * 0.2 +
        count_coin_0_1 * 0.1
    ).toFixed(2);
    if (input_physical) {
        input_physical.value = physical_cash;
    }
    full.value = (parseFloat(physical_cash) + parseFloat(digital_cash)).toFixed(2);
    state.value = (parseFloat(full.value) - parseFloat(payment.value || 0)).toFixed(2);
    updateChangeName(state);
}
const updateChangeName=(state) =>{
    let balance_label = document.getElementById("payment_balance_label");
    if (state.value < 0) {
        balance_label.innerHTML = "SALDO FALTANTE";
        state.style.background = "#ef4444";
    } else if (state.value > 0) {
        balance_label.innerHTML = "SALDO SOBRANTE";
        state.style.background = "#22c55e";
    } else {
        balance_label.innerHTML = "SALDO NIVELADO";
        state.style.background = "#eab308";
    }
}
