async function fetch_detail_cashshift(base, uuid) {
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
            if (data.denomination_open) {
                document.querySelector(`#modal-denomination-open-${uuid}`).classList.remove('hidden');
                document.querySelector(`#quantity-bill-200-${uuid}`).textContent = data.denomination_open.bill_200 ?? 0;
                document.querySelector(`#quantity-bill-100-${uuid}`).textContent = data.denomination_open.bill_100 ?? 0;
                document.querySelector(`#quantity-bill-50-${uuid}`).textContent = data.denomination_open.bill_50 ?? 0;
                document.querySelector(`#quantity-bill-20-${uuid}`).textContent = data.denomination_open.bill_20 ?? 0;
                document.querySelector(`#quantity-bill-10-${uuid}`).textContent = data.denomination_open.bill_10 ?? 0;
                document.querySelector(`#quantity-coin-5-${uuid}`).textContent = data.denomination_open.coin_5 ?? 0;
                document.querySelector(`#quantity-coin-2-${uuid}`).textContent = data.denomination_open.coin_2 ?? 0;
                document.querySelector(`#quantity-coin-1-${uuid}`).textContent = data.denomination_open.coin_1 ?? 0;
                document.querySelector(`#quantity-coin-0-5-${uuid}`).textContent = data.denomination_open.coin_0_5 ?? 0;
                document.querySelector(`#quantity-coin-0-2-${uuid}`).textContent = data.denomination_open.coin_0_2 ?? 0;
                document.querySelector(`#quantity-coin-0-1-${uuid}`).textContent = data.denomination_open.coin_0_1 ?? 0;
                document.querySelector(`#operation-bill-200-${uuid}`).textContent = data.operation_open.bill_200 ?? 0;
                document.querySelector(`#operation-bill-100-${uuid}`).textContent = data.operation_open.bill_100 ?? 0;
                document.querySelector(`#operation-bill-50-${uuid}`).textContent = data.operation_open.bill_50 ?? 0;
                document.querySelector(`#operation-bill-20-${uuid}`).textContent = data.operation_open.bill_20 ?? 0;
                document.querySelector(`#operation-bill-10-${uuid}`).textContent = data.operation_open.bill_10 ?? 0;
                document.querySelector(`#operation-coin-5-${uuid}`).textContent = data.operation_open.coin_5 ?? 0;
                document.querySelector(`#operation-coin-2-${uuid}`).textContent = data.operation_open.coin_2 ?? 0;
                document.querySelector(`#operation-coin-1-${uuid}`).textContent = data.operation_open.coin_1 ?? 0;
                document.querySelector(`#operation-coin-0-5-${uuid}`).textContent = data.operation_open.coin_0_5 ?? 0;
                document.querySelector(`#operation-coin-0-2-${uuid}`).textContent = data.operation_open.coin_0_2 ?? 0;
                document.querySelector(`#operation-coin-0-1-${uuid}`).textContent = data.operation_open.coin_0_1 ?? 0;
                document.querySelector(`#total-${uuid}`).textContent = data.denomination_open.total ?? 0;
            }
            if (data.denomination_close) {
                document.querySelector(`#modal-denomination-close-${uuid}`).classList.remove('hidden');
                document.querySelector(`#value-bill-200-${uuid}`).textContent = data.denomination_close.bill_200 ?? 0;
                document.querySelector(`#value-bill-100-${uuid}`).textContent = data.denomination_close.bill_100 ?? 0;
                document.querySelector(`#value-bill-50-${uuid}`).textContent = data.denomination_close.bill_50 ?? 0;
                document.querySelector(`#value-bill-20-${uuid}`).textContent = data.denomination_close.bill_20 ?? 0;
                document.querySelector(`#value-bill-10-${uuid}`).textContent = data.denomination_close.bill_10 ?? 0;
                document.querySelector(`#value-coin-5-${uuid}`).textContent = data.denomination_close.coin_5 ?? 0;
                document.querySelector(`#value-coin-2-${uuid}`).textContent = data.denomination_close.coin_2 ?? 0;
                document.querySelector(`#value-coin-1-${uuid}`).textContent = data.denomination_close.coin_1 ?? 0;
                document.querySelector(`#value-coin-0-5-${uuid}`).textContent = data.denomination_close.coin_0_5 ?? 0;
                document.querySelector(`#value-coin-0-2-${uuid}`).textContent = data.denomination_close.coin_0_2 ?? 0;
                document.querySelector(`#value-coin-0-1-${uuid}`).textContent = data.denomination_close.coin_0_1 ?? 0;
                document.querySelector(`#amount-bill-200-${uuid}`).textContent = data.operation_close.bill_200 ?? 0;
                document.querySelector(`#amount-bill-100-${uuid}`).textContent = data.operation_close.bill_100 ?? 0;
                document.querySelector(`#amount-bill-50-${uuid}`).textContent = data.operation_close.bill_50 ?? 0;
                document.querySelector(`#amount-bill-20-${uuid}`).textContent = data.operation_close.bill_20 ?? 0;
                document.querySelector(`#amount-bill-10-${uuid}`).textContent = data.operation_close.bill_10 ?? 0;
                document.querySelector(`#amount-coin-5-${uuid}`).textContent = data.operation_close.coin_5 ?? 0;
                document.querySelector(`#amount-coin-2-${uuid}`).textContent = data.operation_close.coin_2 ?? 0;
                document.querySelector(`#amount-coin-1-${uuid}`).textContent = data.operation_close.coin_1 ?? 0;
                document.querySelector(`#amount-coin-0-5-${uuid}`).textContent = data.operation_close.coin_0_5 ?? 0;
                document.querySelector(`#amount-coin-0-2-${uuid}`).textContent = data.operation_close.coin_0_2 ?? 0;
                document.querySelector(`#amount-coin-0-1-${uuid}`).textContent = data.operation_close.coin_0_1 ?? 0;
                document.querySelector(`#total-close-${uuid}`).textContent = data.denomination_close.total ?? 0;
            }
            if (data.cashregister_open.length > 0) {
                document.querySelector(`#modal-cashregister-open-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-cashregister-open-${uuid}`);
                const content_total = document.querySelector(`#total-cashregister-open-${uuid}`);
                fill_data(content_method, content_total, data.cashregister_open);
            }
            if (data.bankregister_open.length > 0) {
                document.querySelector(`#modal-bankregister-open-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-bankregister-open-${uuid}`);
                const content_total = document.querySelector(`#total-bankregister-open-${uuid}`);
                fill_data(content_method, content_total, data.bankregister_open);
            }
            if (data.platform_open.length > 0) {
                document.querySelector(`#modal-platform-open-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-platform-open-${uuid}`);
                const content_total = document.querySelector(`#total-platform-open-${uuid}`);
                fill_data(content_method, content_total, data.platform_open);
            }
            if (data.cashregister_close.length > 0) {
                document.querySelector(`#modal-cashregister-close-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-cashregister-close-${uuid}`);
                const content_total = document.querySelector(`#total-cashregister-close-${uuid}`);
                fill_data(content_method, content_total, data.cashregister_close);
            }
            if (data.bankregister_close.length > 0) {
                document.querySelector(`#modal-bankregister-close-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-bankregister-close-${uuid}`);
                const content_total = document.querySelector(`#total-bankregister-close-${uuid}`);
                fill_data(content_method, content_total, data.bankregister_close);
            }
            if (data.platform_close.length > 0) {
                document.querySelector(`#modal-platform-close-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-platform-close-${uuid}`);
                const content_total = document.querySelector(`#total-platform-close-${uuid}`);
                fill_data(content_method, content_total, data.platform_close);
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
const fill_data=(content_method, content_total, input)=>{
    while (content_method.firstChild) {
        content_method.removeChild(content_method.firstChild);
    }
    while (content_total.firstChild) {
        content_total.removeChild(content_total.firstChild);
    }
    const fragment_name = document.createDocumentFragment();
    const fragment_total = document.createDocumentFragment();
    input.forEach(item => {
        let name = document.createElement('p');
        let total = document.createElement('p');
        name.textContent = item.name;
        total.textContent = item.total;
        fragment_name.appendChild(name);
        fragment_total.appendChild(total);
    });
    content_method.appendChild(fragment_name);
    content_total.appendChild(fragment_total);
}
