async function fetch_date(element, base, e) {
    e.preventDefault();
    loader_action_status('show');
    const date = element.value;
    const url_aux = document.getElementById('session-date').getAttribute('href');
    const url = `${url_aux}?date=${date}`;
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
                dashboard_summary.innerHTML = data.summary_html;
            }
            const dashboard_session = document.getElementById('dashboard-session');
            if (dashboard_session) {
                dashboard_session.innerHTML = data.session_html;
            }
            location.reload();
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
