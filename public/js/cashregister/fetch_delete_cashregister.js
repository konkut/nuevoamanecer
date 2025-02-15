const fetch_delete_cashregister = async (form, base, uuid, e) => {
    e.preventDefault();
    closeModal(uuid);
    loader_action_status('show');
    const url = form.action;
    const formData = new FormData(form);
    const body = Object.fromEntries(formData.entries());
    try {
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf_token,
            },
            body: JSON.stringify(body),
        });
        loader_action_status('hide');
        const data = await response.json();
        if (!response.ok) {
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
                msgs: data?.msgs,
                base_url: base,
            });
            return;
        }
        if (response.status === 200) {
            mdalert({
                title: data?.title,
                type: data?.type,
                msg: data?.msg,
                base_url: base,
            });
            setTimeout(() => {
                window.location.href = data?.redirect || window.location.origin + "/cashregisters";
            }, 1000);
            return;
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
};



