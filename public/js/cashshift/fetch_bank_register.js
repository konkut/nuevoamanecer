async function fetch_amount_cashshift(uuid) {
    loader_action_status('show');
    const url = document.getElementById(`amount-form-${uuid}`).href;
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
        let amount_input = document.querySelectorAll('.amount-input');
        let bank_select = document.querySelectorAll('.bank-select');
        bank_select.forEach((select, index) => {
            let selected_bank = select.options[select.selectedIndex];
            let selected_amount = amount_input[index];
            let name = selected_bank.getAttribute('data-name');
            if (data.name === name) {
                selected_amount.value = parseFloat(data.amount);
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

