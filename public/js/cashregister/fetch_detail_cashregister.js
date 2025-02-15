async function fetch_detail_cashregister(base, uuid) {
    loader_action_status('show');
    const form = document.getElementById(`details-form-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        loader_action_status('hide');
        const data = await response.json();
        if (!response.ok) {
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
                base_url: base,
            });
            return;
        }
        if (response.status === 200) {
            if (document.querySelector(`#modal-show-${uuid}`)) {
                document.querySelector(`#quantity-bill-200-${uuid}`).textContent = data.denomination.bill_200 ?? 0;
                document.querySelector(`#quantity-bill-100-${uuid}`).textContent = data.denomination.bill_100 ?? 0;
                document.querySelector(`#quantity-bill-50-${uuid}`).textContent = data.denomination.bill_50 ?? 0;
                document.querySelector(`#quantity-bill-20-${uuid}`).textContent = data.denomination.bill_20 ?? 0;
                document.querySelector(`#quantity-bill-10-${uuid}`).textContent = data.denomination.bill_10 ?? 0;
                document.querySelector(`#quantity-coin-5-${uuid}`).textContent = data.denomination.coin_5 ?? 0;
                document.querySelector(`#quantity-coin-2-${uuid}`).textContent = data.denomination.coin_2 ?? 0;
                document.querySelector(`#quantity-coin-1-${uuid}`).textContent = data.denomination.coin_1 ?? 0;
                document.querySelector(`#quantity-coin-0-5-${uuid}`).textContent = data.denomination.coin_0_5 ?? 0;
                document.querySelector(`#quantity-coin-0-2-${uuid}`).textContent = data.denomination.coin_0_2 ?? 0;
                document.querySelector(`#quantity-coin-0-1-${uuid}`).textContent = data.denomination.coin_0_1 ?? 0;

                document.querySelector(`#operation-bill-200-${uuid}`).textContent = data.operation.bill_200 ?? 0;
                document.querySelector(`#operation-bill-100-${uuid}`).textContent = data.operation.bill_100 ?? 0;
                document.querySelector(`#operation-bill-50-${uuid}`).textContent = data.operation.bill_50 ?? 0;
                document.querySelector(`#operation-bill-20-${uuid}`).textContent = data.operation.bill_20 ?? 0;
                document.querySelector(`#operation-bill-10-${uuid}`).textContent = data.operation.bill_10 ?? 0;
                document.querySelector(`#operation-coin-5-${uuid}`).textContent = data.operation.coin_5 ?? 0;
                document.querySelector(`#operation-coin-2-${uuid}`).textContent = data.operation.coin_2 ?? 0;
                document.querySelector(`#operation-coin-1-${uuid}`).textContent = data.operation.coin_1 ?? 0;
                document.querySelector(`#operation-coin-0-5-${uuid}`).textContent = data.operation.coin_0_5 ?? 0;
                document.querySelector(`#operation-coin-0-2-${uuid}`).textContent = data.operation.coin_0_2 ?? 0;
                document.querySelector(`#operation-coin-0-1-${uuid}`).textContent = data.operation.coin_0_1 ?? 0;
                document.querySelector(`#total-${uuid}`).textContent = data.denomination.total ?? 0;
            }
            openDetailsModal(uuid);
        }
    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"],
            base_url: base,
        });
    }
}
