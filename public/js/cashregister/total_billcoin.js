const updateTotalandBalance = () => {
    let total = document.getElementById("total");
    document.addEventListener('input', (event) => {
        if (event.target.matches('#bill_200, #bill_100, #bill_50, #bill_20, #bill_10, #coin_5, #coin_2, #coin_1, #coin_0_5, #coin_0_2, #coin_0_1')) {
            const input = event.target;
            const validRegex = /^-?\d*(\.\d{0,2})?$/;
            if (!validRegex.test(input.value)) {
                input.value = input.value.slice(0, -1);
            }
        }
    });
    let count_bill_200 = parseFloat(document.getElementById("bill_200").value) || 0;
    let count_bill_100 = parseFloat(document.getElementById("bill_100").value) || 0;
    let count_bill_50 = parseFloat(document.getElementById("bill_50").value) || 0;
    let count_bill_20 = parseFloat(document.getElementById("bill_20").value) || 0;
    let count_bill_10 = parseFloat(document.getElementById("bill_10").value) || 0;
    let count_coin_5 = parseFloat(document.getElementById("coin_5").value) || 0;
    let count_coin_2 = parseFloat(document.getElementById("coin_2").value) || 0;
    let count_coin_1 = parseFloat(document.getElementById("coin_1").value) || 0;
    let count_coin_0_5 = parseFloat(document.getElementById("coin_0_5").value) || 0;
    let count_coin_0_2 = parseFloat(document.getElementById("coin_0_2").value) || 0;
    let count_coin_0_1 = parseFloat(document.getElementById("coin_0_1").value) || 0;
    let overall = (
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
    total.value = parseFloat(overall).toFixed(2);
}
