async function fetch_balance(uuid) {
    loader_action_status('show');
    const url = document.getElementById(`balance-form-${uuid}`).href;
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        loader_action_status('hide');
        if (!response.ok) {
            const data = await response.json();
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
            });
            return;
        }
        const data = await response.json();
        let balance_input = document.querySelectorAll('.balance-input');
        let bank_select = document.querySelectorAll('.bank-select');
        bank_select.forEach((method, index) => {
            let selected_bank = method.options[method.selectedIndex];
            const name_select = selected_bank.getAttribute('data-name');
            const balance = balance_input[index];
            if (data.name === name_select) {
                balance.value = parseFloat(data.balance);
            }
        });
    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"]
        });
    }
}

