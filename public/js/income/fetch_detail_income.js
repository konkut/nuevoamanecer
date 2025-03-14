async function fetch_detail_income(base, uuid) {
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
            if (data.denomination_input) {
                document.querySelector(`#modal-denomination-input-${uuid}`).classList.remove('hidden');
                document.querySelector(`#quantity-bill-200-${uuid}`).textContent = data.denomination_input.bill_200 ?? 0;
                document.querySelector(`#quantity-bill-100-${uuid}`).textContent = data.denomination_input.bill_100 ?? 0;
                document.querySelector(`#quantity-bill-50-${uuid}`).textContent = data.denomination_input.bill_50 ?? 0;
                document.querySelector(`#quantity-bill-20-${uuid}`).textContent = data.denomination_input.bill_20 ?? 0;
                document.querySelector(`#quantity-bill-10-${uuid}`).textContent = data.denomination_input.bill_10 ?? 0;
                document.querySelector(`#quantity-coin-5-${uuid}`).textContent = data.denomination_input.coin_5 ?? 0;
                document.querySelector(`#quantity-coin-2-${uuid}`).textContent = data.denomination_input.coin_2 ?? 0;
                document.querySelector(`#quantity-coin-1-${uuid}`).textContent = data.denomination_input.coin_1 ?? 0;
                document.querySelector(`#quantity-coin-0-5-${uuid}`).textContent = data.denomination_input.coin_0_5 ?? 0;
                document.querySelector(`#quantity-coin-0-2-${uuid}`).textContent = data.denomination_input.coin_0_2 ?? 0;
                document.querySelector(`#quantity-coin-0-1-${uuid}`).textContent = data.denomination_input.coin_0_1 ?? 0;
                document.querySelector(`#operation-bill-200-${uuid}`).textContent = data.operation_input.bill_200 ?? 0;
                document.querySelector(`#operation-bill-100-${uuid}`).textContent = data.operation_input.bill_100 ?? 0;
                document.querySelector(`#operation-bill-50-${uuid}`).textContent = data.operation_input.bill_50 ?? 0;
                document.querySelector(`#operation-bill-20-${uuid}`).textContent = data.operation_input.bill_20 ?? 0;
                document.querySelector(`#operation-bill-10-${uuid}`).textContent = data.operation_input.bill_10 ?? 0;
                document.querySelector(`#operation-coin-5-${uuid}`).textContent = data.operation_input.coin_5 ?? 0;
                document.querySelector(`#operation-coin-2-${uuid}`).textContent = data.operation_input.coin_2 ?? 0;
                document.querySelector(`#operation-coin-1-${uuid}`).textContent = data.operation_input.coin_1 ?? 0;
                document.querySelector(`#operation-coin-0-5-${uuid}`).textContent = data.operation_input.coin_0_5 ?? 0;
                document.querySelector(`#operation-coin-0-2-${uuid}`).textContent = data.operation_input.coin_0_2 ?? 0;
                document.querySelector(`#operation-coin-0-1-${uuid}`).textContent = data.operation_input.coin_0_1 ?? 0;
                document.querySelector(`#total-${uuid}`).textContent = data.denomination_input.total ?? 0;
            }
            if (data.denomination_output) {
                document.querySelector(`#modal-denomination-output-${uuid}`).classList.remove('hidden');
                document.querySelector(`#value-bill-200-${uuid}`).textContent = data.denomination_output.bill_200 ?? 0;
                document.querySelector(`#value-bill-100-${uuid}`).textContent = data.denomination_output.bill_100 ?? 0;
                document.querySelector(`#value-bill-50-${uuid}`).textContent = data.denomination_output.bill_50 ?? 0;
                document.querySelector(`#value-bill-20-${uuid}`).textContent = data.denomination_output.bill_20 ?? 0;
                document.querySelector(`#value-bill-10-${uuid}`).textContent = data.denomination_output.bill_10 ?? 0;
                document.querySelector(`#value-coin-5-${uuid}`).textContent = data.denomination_output.coin_5 ?? 0;
                document.querySelector(`#value-coin-2-${uuid}`).textContent = data.denomination_output.coin_2 ?? 0;
                document.querySelector(`#value-coin-1-${uuid}`).textContent = data.denomination_output.coin_1 ?? 0;
                document.querySelector(`#value-coin-0-5-${uuid}`).textContent = data.denomination_output.coin_0_5 ?? 0;
                document.querySelector(`#value-coin-0-2-${uuid}`).textContent = data.denomination_output.coin_0_2 ?? 0;
                document.querySelector(`#value-coin-0-1-${uuid}`).textContent = data.denomination_output.coin_0_1 ?? 0;
                document.querySelector(`#amount-bill-200-${uuid}`).textContent = data.operation_output.bill_200 ?? 0;
                document.querySelector(`#amount-bill-100-${uuid}`).textContent = data.operation_output.bill_100 ?? 0;
                document.querySelector(`#amount-bill-50-${uuid}`).textContent = data.operation_output.bill_50 ?? 0;
                document.querySelector(`#amount-bill-20-${uuid}`).textContent = data.operation_output.bill_20 ?? 0;
                document.querySelector(`#amount-bill-10-${uuid}`).textContent = data.operation_output.bill_10 ?? 0;
                document.querySelector(`#amount-coin-5-${uuid}`).textContent = data.operation_output.coin_5 ?? 0;
                document.querySelector(`#amount-coin-2-${uuid}`).textContent = data.operation_output.coin_2 ?? 0;
                document.querySelector(`#amount-coin-1-${uuid}`).textContent = data.operation_output.coin_1 ?? 0;
                document.querySelector(`#amount-coin-0-5-${uuid}`).textContent = data.operation_output.coin_0_5 ?? 0;
                document.querySelector(`#amount-coin-0-2-${uuid}`).textContent = data.operation_output.coin_0_2 ?? 0;
                document.querySelector(`#amount-coin-0-1-${uuid}`).textContent = data.operation_output.coin_0_1 ?? 0;
                document.querySelector(`#total-payment-${uuid}`).textContent = data.denomination_output.total ?? 0;
            }
            if (data.cashregister_input.length > 0 || data.cashregister_output.length > 0) {
                document.querySelector(`#modal-cashregister-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-cashregister-${uuid}`);
                const content_total = document.querySelector(`#total-cashregister-${uuid}`);
                fill_data(content_method, content_total, data.cashregister_input, data.cashregister_output);
            }
            if (data.bankregister_input.length > 0 || data.bankregister_output.length > 0) {
                document.querySelector(`#modal-bankregister-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-bankregister-${uuid}`);
                const content_total = document.querySelector(`#total-bankregister-${uuid}`);
                fill_data(content_method, content_total, data.bankregister_input, data.bankregister_output);
            }
            if (data.platform_input.length > 0 || data.platform_output.length > 0) {
                document.querySelector(`#modal-platform-${uuid}`).classList.remove('hidden');
                const content_method = document.querySelector(`#method-platform-${uuid}`);
                const content_total = document.querySelector(`#total-platform-${uuid}`);
                fill_data(content_method, content_total, data.platform_input, data.platform_output);
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

const fill_data=(content_method, content_total, input, output)=>{
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
    output.forEach(item => {
        let name = document.createElement('p');
        let total = document.createElement('p');
        name.textContent = item.name;
        total.textContent = `(${item.total})`;
        fragment_name.appendChild(name);
        fragment_total.appendChild(total);
    });
    content_method.appendChild(fragment_name);
    content_total.appendChild(fragment_total);
}
