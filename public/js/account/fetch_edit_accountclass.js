const fetch_edit_accountclass = async (element, base, uuid, e) => {
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
            document.querySelector(`#code-${uuid}`).textContent = data?.accountclass?.code;
            document.querySelector(`#accountclass-${uuid}`).value = data?.accountclass?.name;
            document.querySelector(`#description-${uuid}`).value = data?.accountclass?.description;
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



