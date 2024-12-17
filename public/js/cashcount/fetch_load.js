function fetchLoad(uuid) {
    const form = document.getElementById(`load-form-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById(`system_balance-${uuid}`).textContent = parseFloat(data.system_balance).toFixed(2);
            document.getElementById(`difference-${uuid}`).textContent = parseFloat(data.difference).toFixed(2);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
