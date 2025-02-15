async function fetch_value_cashshift(base, uuid) {
    loader_action_status('show');
    const url = document.getElementById(`value-form-${uuid}`).href;
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
        let value_input = document.querySelectorAll('.value-input');
        let platform_select = document.querySelectorAll('.platform-select');
        platform_select.forEach((select, index) => {
            let selected_platform = select.options[select.selectedIndex];
            let selected_value = value_input[index];
            let name = selected_platform.getAttribute('data-name');
            if (data.name === name) {
                selected_value.value = parseFloat(data.value);
            }
        });
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

