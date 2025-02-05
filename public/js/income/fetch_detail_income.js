async function fetch_detail_income(uuid) {
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
            });
            return;
        }
        if (response.status === 200) {
            if (data.denomination) {
                document.querySelector(`#modal-denomination-${uuid}`).classList.remove('hidden');
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
            if (data.transaction) {
                document.querySelector(`#modal-transaction-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-transaction-${uuid}`);
                const content_total = document.querySelector(`#total-transaction-${uuid}`);
                while (content_method.firstChild) {
                    content_method.removeChild(content_method.firstChild);
                }
                while (content_total.firstChild) {
                    content_total.removeChild(content_total.firstChild);
                }
                const fragment_name = document.createDocumentFragment();
                const fragment_total = document.createDocumentFragment();
                data.transaction.forEach(item => {
                    let name = document.createElement('p');
                    let total = document.createElement('p');
                    name.classList.add('py-0.5');
                    total.classList.add('py-0.5');
                    name.textContent = item.name;
                    total.textContent = item.total.toFixed(2);
                    fragment_name.appendChild(name);
                    fragment_total.appendChild(total);
                });
                content_method.appendChild(fragment_name);
                content_total.appendChild(fragment_total);
            }
            openDetailsModal(uuid);
        }

    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"]
        });
    }
}
