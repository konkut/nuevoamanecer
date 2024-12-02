async function fetchDetailsForm(uuid) {
    const form = document.getElementById(`details-forms-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error('Error en la petición');
        }

        const data = await response.json();

        let contain_bill_coin_price = document.getElementById('contain_bill_coin_price');
        contain_bill_coin_price.innerHTML = "";
        console.log(data);

        if (data.bill_200 != 0) contain_bill_coin_price.innerHTML += `
            <div>
                <p><span class="text-sm font-semibold">Bs 200 - Cantidad:</span> ${data.bill_200}</p>
            </div>`;
        if (data.bill_100 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 100 - Cantidad:</span> ${data.bill_100}</p>
            </div>`;
        if (data.bill_50 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 50 - Cantidad:</span> ${data.bill_50}</p>
            </div>`;
        if (data.bill_20 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 20 - Cantidad:</span> ${data.bill_20}</p>
            </div>`;
        if (data.bill_10 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 10 - Cantidad:</span> ${data.bill_10}</p>
            </div>`;
        if (data.coin_5 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 5 - Cantidad:</span> ${data.coin_5}</p>
            </div>`;
        if (data.coin_2 != 0) contain_bill_coin.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 2 - Cantidad:</span> ${data.coin_2}</p>
            </div>`;
        if (data.coin_1 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 1 - Cantidad:</span> ${data.coin_1}</p>
            </div>`;
        if (data.coin_0_5 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 0.5 - Cantidad:</span> ${data.coin_0_5}</p>
            </div>`;
        if (data.coin_0_2 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 0.2 - Cantidad:</span> ${data.coin_0_2}</p>
            </div>`;
        if (data.coin_0_1 != 0) contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Bs 0.1 - Cantidad:</span> ${data.coin_0_1}</p>
            </div>`;
        contain_bill_coin_price.innerHTML += `
            <div class="mt-4">
                <p><span class="text-sm font-semibold">Total:</span> ${data.total}</p>
            </div>`;

        openDetailsModal(uuid);
    } catch (error) {
        console.error('Error:', error);
    }
}
