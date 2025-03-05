async function fetch_session(element, base, uuid, e) {
    e.preventDefault();
    loader_action_status('show');
    const url = document.getElementById(`session-form-${uuid}`).href;
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
            const dashboard_summary = document.getElementById('dashboard-summary');
            if (dashboard_summary) {
                dashboard_summary.classList.add('gap-8');
                dashboard_summary.innerHTML = data.summary_html;
            }
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



