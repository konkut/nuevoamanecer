function fetchDetailCashshift(uuid) {
    const form = document.getElementById(`details-cashshift-form-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            if (document.querySelector(`#show-opening-modal-${uuid}`)) {
                document.querySelector(`#initial-balance-bill-200-${uuid}`).textContent = data.denomination.bill_200 ?? 0;
                document.querySelector(`#initial-balance-bill-100-${uuid}`).textContent = data.denomination.bill_100 ?? 0;
                document.querySelector(`#initial-balance-bill-50-${uuid}`).textContent = data.denomination.bill_50 ?? 0;
                document.querySelector(`#initial-balance-bill-20-${uuid}`).textContent = data.denomination.bill_20 ?? 0;
                document.querySelector(`#initial-balance-bill-10-${uuid}`).textContent = data.denomination.bill_10 ?? 0;
                document.querySelector(`#initial-balance-coin-5-${uuid}`).textContent = data.denomination.coin_5 ?? 0;
                document.querySelector(`#initial-balance-coin-2-${uuid}`).textContent = data.denomination.coin_2 ?? 0;
                document.querySelector(`#initial-balance-coin-1-${uuid}`).textContent = data.denomination.coin_1 ?? 0;
                document.querySelector(`#initial-balance-coin-0-5-${uuid}`).textContent = data.denomination.coin_0_5 ?? 0;
                document.querySelector(`#initial-balance-coin-0-2-${uuid}`).textContent = data.denomination.coin_0_2 ?? 0;
                document.querySelector(`#initial-balance-coin-0-1-${uuid}`).textContent = data.denomination.coin_0_1 ?? 0;
                document.querySelector(`#initial-balance-total-${uuid}`).textContent = data.denomination.total ?? 0;
            }
            openDetailsModal(uuid);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
