async function fetch_price_cashshift(base, uuid) {
    loader_action_status('show');
    const url = document.getElementById(`price-form-${uuid}`).href;
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
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
        document.querySelector(`#price`).value = data.denomination.total;
        document.querySelector(`#bill_200`).value = data.denomination.bill_200;
        document.querySelector(`#bill_100`).value = data.denomination.bill_100;
        document.querySelector(`#bill_50`).value = data.denomination.bill_50;
        document.querySelector(`#bill_20`).value = data.denomination.bill_20;
        document.querySelector(`#bill_10`).value = data.denomination.bill_10;
        document.querySelector(`#coin_5`).value = data.denomination.coin_5;
        document.querySelector(`#coin_2`).value = data.denomination.coin_2;
        document.querySelector(`#coin_1`).value = data.denomination.coin_1;
        document.querySelector(`#coin_0_5`).value = data.denomination.coin_0_5;
        document.querySelector(`#coin_0_2`).value = data.denomination.coin_0_2;
        document.querySelector(`#coin_0_1`).value = data.denomination.coin_0_1;
        document.querySelector(`#charge`).value = data.denomination.total;
        update_price_cashshift();
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

