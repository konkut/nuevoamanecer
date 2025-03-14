const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function load_accounting() {
    /*ACCOUNTING*/
    const select_project = document.querySelector('#project_uuid');
    const project_uuid = localStorage.getItem('project_uuid');
    for (let option of select_project.options) {
        if (option.value === project_uuid) {
            option.selected = true;
            break;
        }
    }
    /*LEDGER*/
    let query = localStorage.getItem("query");
    let analyticalaccount_uuid = localStorage.getItem("analyticalaccount_uuid");
    let input = document.querySelector("#query");
    let select = document.querySelector(".select-analyticalaccount");
    if (query && input) {
        input.value = query;
    }
    if (analyticalaccount_uuid && select){
        select.querySelectorAll('option').forEach(option => {
            if (option.value == analyticalaccount_uuid) {
                select.value = option.value;
            }
        });
    }
}
window.addEventListener('DOMContentLoaded', load_accounting);


