const fetchData = (uuid) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/cashshifts/data`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },body: JSON.stringify({ cashregister_uuid: uuid })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            document.querySelector(`#initial_balance`).value = data.initial_balance;
            document.querySelector(`#bill_200`).value = data.bill_200;
            document.querySelector(`#bill_100`).value = data.bill_100;
            document.querySelector(`#bill_50`).value = data.bill_50;
            document.querySelector(`#bill_20`).value = data.bill_20;
            document.querySelector(`#bill_10`).value = data.bill_10;
            document.querySelector(`#coin_5`).value = data.coin_5;
            document.querySelector(`#coin_2`).value = data.coin_2;
            document.querySelector(`#coin_1`).value = data.coin_1;
            document.querySelector(`#coin_0_5`).value = data.coin_0_5;
            document.querySelector(`#coin_0_2`).value = data.coin_0_2;
            document.querySelector(`#coin_0_1`).value = data.coin_0_1;
            document.querySelector(`#charge`).value = data.initial_balance;
            updateChargeFromCashshift();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
