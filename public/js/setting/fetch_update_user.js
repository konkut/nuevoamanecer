const fetch_update_user = async (form, e) => {
    e.preventDefault();
    loader_action_status('show');
    const url = form.action;
    const formData = new FormData(form);
    const body = Object.fromEntries(formData.entries());
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrf_token,
            },
            body: JSON.stringify(body),
        });
        loader_action_status('hide');
        if (!response.ok) {
            const data = await response.json();
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
                msgs: data?.msgs,
            });
            return;
        }
        if (response.status === 200){
            const data = await response.json();
            mdalert({
                title: data?.title,
                type: data?.type,
                msg: data?.msg,
            });
            return;
        }
        //window.location.href = location.protocol + "//" + location.host + "/dashboard";
    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"],
        });
    }
};

