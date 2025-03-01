const search_account = (element)=>{
    let filter = element.value.toLowerCase();
    let index = element.getAttribute('data-index');
    let select_accounts = document.querySelectorAll('.select-account');
    select_accounts.forEach(select=>{
        if(select.getAttribute('data-index') == index){
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
            } else {
                select.value = "";
            }
            if(filter == "") select.value = "";
        }
    })
}
