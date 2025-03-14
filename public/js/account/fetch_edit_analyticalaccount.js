const fetch_edit_analyticalaccount = async (element, base, uuid, e) => {
    e.preventDefault();
    loader_action_status('show');
    const url = element.href;
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
        if (response.status === 200) {
            document.querySelector(`#code-${uuid}`).textContent = data?.analyticalaccount?.code;
            document.querySelector(`#analyticalaccount-${uuid}`).value = data?.analyticalaccount?.name;
            document.querySelector(`#description-${uuid}`).value = data?.analyticalaccount?.description;
            let select_mainaccount = document.querySelector(`#mainaccount_uuid-${uuid}`);
            for (let option of select_mainaccount.options) {
                if (option.value == data?.analyticalaccount?.mainaccount_uuid) {
                    option.selected = true;
                    break;
                }
            }
            open_edit_modal(uuid);
            first_focus_edit(uuid);
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



