async function fetch_session(event, uuid, element) {
    loader_action_status('show');
    const url = document.getElementById(`session-form-${uuid}`).href;
    const allCards = document.querySelectorAll('#dashboard-session div');
    allCards.forEach(card => {
        card.style.background = '';
    });
    element.style.background = '#FFFBEB';
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
        const dashboard_summary = document.getElementById('dashboard-summary');
        if (dashboard_summary) {
            dashboard_summary.innerHTML = data.summary_html;
        }
    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"]
        });
    }
}



