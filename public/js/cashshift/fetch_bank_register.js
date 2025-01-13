const fetch_balance = (uuid) => {
    const url = document.getElementById(`balance-form-${uuid}`).href;
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            let balance_input = document.querySelectorAll('.balance-input');
            let bank_select = document.querySelectorAll('.bank-select');
            bank_select.forEach((method, index) => {
                let selected_bank = method.options[method.selectedIndex];
                const name_select = selected_bank.getAttribute('data-name');
                const balance = balance_input[index];
                if (data.name === name_select) {
                    balance.value = parseFloat(data.balance);
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
