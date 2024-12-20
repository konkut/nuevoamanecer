function fetchDetails(uuid) {
    const form = document.getElementById(`details-form-${uuid}`);
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
            document.querySelector(`#physical-balance-bill-200-${uuid}`).textContent = data.bill_200 ?? 0;
            document.querySelector(`#physical-balance-bill-100-${uuid}`).textContent = data.bill_100 ?? 0;
            document.querySelector(`#physical-balance-bill-50-${uuid}`).textContent = data.bill_50 ?? 0;
            document.querySelector(`#physical-balance-bill-20-${uuid}`).textContent = data.bill_20 ?? 0;
            document.querySelector(`#physical-balance-bill-10-${uuid}`).textContent = data.bill_10 ?? 0;
            document.querySelector(`#physical-balance-coin-5-${uuid}`).textContent = data.coin_5 ?? 0;
            document.querySelector(`#physical-balance-coin-2-${uuid}`).textContent = data.coin_2 ?? 0;
            document.querySelector(`#physical-balance-coin-1-${uuid}`).textContent = data.coin_1 ?? 0;
            document.querySelector(`#physical-balance-coin-0-5-${uuid}`).textContent = data.coin_0_5 ?? 0;
            document.querySelector(`#physical-balance-coin-0-2-${uuid}`).textContent = data.coin_0_2 ?? 0;
            document.querySelector(`#physical-balance-coin-0-1-${uuid}`).textContent = data.coin_0_1 ?? 0;
            document.querySelector(`#physical-balance-total-${uuid}`).textContent = data.total ?? 0;
           if(document.querySelector(`#show-movement-modal-${uuid}`)){
               document.querySelector(`#system-balance-bill-200-${uuid}`).textContent = data.total_bill_200 ?? 0;
               document.querySelector(`#system-balance-bill-100-${uuid}`).textContent = data.total_bill_100 ?? 0;
               document.querySelector(`#system-balance-bill-50-${uuid}`).textContent = data.total_bill_50 ?? 0;
               document.querySelector(`#system-balance-bill-20-${uuid}`).textContent = data.total_bill_20 ?? 0;
               document.querySelector(`#system-balance-bill-10-${uuid}`).textContent = data.total_bill_10 ?? 0;
               document.querySelector(`#system-balance-coin-5-${uuid}`).textContent = data.total_coin_5 ?? 0;
               document.querySelector(`#system-balance-coin-2-${uuid}`).textContent = data.total_coin_2 ?? 0;
               document.querySelector(`#system-balance-coin-1-${uuid}`).textContent = data.total_coin_1 ?? 0;
               document.querySelector(`#system-balance-coin-0-5-${uuid}`).textContent = data.total_coin_0_5 ?? 0;
               document.querySelector(`#system-balance-coin-0-2-${uuid}`).textContent = data.total_coin_0_2 ?? 0;
               document.querySelector(`#system-balance-coin-0-1-${uuid}`).textContent = data.total_coin_0_1 ?? 0;
               document.querySelector(`#system-balance-total-${uuid}`).textContent = parseFloat(data.total_total).toFixed(2) ?? 0;
           }
            if(document.querySelector(`#show-closing-modal-${uuid}`)){
                document.querySelector(`#total-balance-bill-200-${uuid}`).textContent = data.closing_bill_200 ?? 0;
                document.querySelector(`#total-balance-bill-100-${uuid}`).textContent = data.closing_bill_100 ?? 0;
                document.querySelector(`#total-balance-bill-50-${uuid}`).textContent = data.closing_bill_50 ?? 0;
                document.querySelector(`#total-balance-bill-20-${uuid}`).textContent = data.closing_bill_20 ?? 0;
                document.querySelector(`#total-balance-bill-10-${uuid}`).textContent = data.closing_bill_10 ?? 0;
                document.querySelector(`#total-balance-coin-5-${uuid}`).textContent = data.closing_coin_5 ?? 0;
                document.querySelector(`#total-balance-coin-2-${uuid}`).textContent = data.closing_coin_2 ?? 0;
                document.querySelector(`#total-balance-coin-1-${uuid}`).textContent = data.closing_coin_1 ?? 0;
                document.querySelector(`#total-balance-coin-0-5-${uuid}`).textContent = data.closing_coin_0_5 ?? 0;
                document.querySelector(`#total-balance-coin-0-2-${uuid}`).textContent = data.closing_coin_0_2 ?? 0;
                document.querySelector(`#total-balance-coin-0-1-${uuid}`).textContent = data.closing_coin_0_1 ?? 0;
                document.querySelector(`#total-balance-total-${uuid}`).textContent = parseFloat(data.closing_total).toFixed(2) ?? 0;
            }
            if(document.querySelector(`#system-balance-table-${uuid}`)){
                document.getElementById(`system-balance-table-${uuid}`).textContent = parseFloat(data.total_total).toFixed(2);
            }
            if(document.querySelector(`#difference-table-${uuid}`)){
                document.getElementById(`difference-table-${uuid}`).textContent = parseFloat(data.difference).toFixed(2);
            }
            if(document.querySelector(`#system-balance-modal-${uuid}`)){
                document.getElementById(`system-balance-modal-${uuid}`).textContent = parseFloat(data.total_total).toFixed(2);
            }
            if(document.querySelector(`#difference-modal-${uuid}`)){
                document.getElementById(`difference-modal-${uuid}`).textContent = parseFloat(data.difference).toFixed(2);
            }
            openDetailsModal(uuid);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
