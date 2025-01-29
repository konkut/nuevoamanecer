const fetch_logout_session = async (form, e) => {
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
        const data = await response.json();
        if (!response.ok) {
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
                msgs: data?.msgs,
            });
            return;
        }
        if (response.status === 200) {
            mdalert({
                title: data?.title,
                type: data?.type,
                msg: data?.msg,
            });
            let input = document.querySelector('#password_logout');
            if (input) input.value = "";
            document.querySelectorAll('[data-state]').forEach(element => {
                const state = element.getAttribute('data-state');
                if (state === 'false' || state === '') {
                    element.remove();
                }
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



