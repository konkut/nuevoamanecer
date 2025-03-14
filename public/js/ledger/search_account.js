const search_analyticalaccount = (element) => {
    let filter = element.value.toLowerCase();
    localStorage.setItem("query", element.value);
    let select_accounts = document.querySelectorAll('.select-analyticalaccount');
    select_accounts.forEach(select => {
        let options = select.options;
        let firstMatch = null;
        for (let i = 0; i < options.length; i++) {
            let option = options[i];
            let text = option.textContent.toLowerCase();
            if (text.includes(filter) && option.value !== "") {
                if (!firstMatch) {
                    firstMatch = option;
                }
            }
        }
        if (firstMatch) {
            select.value = firstMatch.value;
            setTimeout(() => {
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }, 10);
            localStorage.setItem("analyticalaccount_uuid", firstMatch.value);
        } else {
            select.value = "";
            localStorage.removeItem("analyticalaccount_uuid");
        }
        if (filter == "") {
            select.value = "";
            localStorage.removeItem("analyticalaccount_uuid");
        }
    })
}
const update_account_uuid = (item) =>{
   localStorage.setItem("analyticalaccount_uuid", item.value);
}
