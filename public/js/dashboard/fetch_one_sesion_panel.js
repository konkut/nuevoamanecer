function fetch_one_sesion(event,uuid, element) {
    const url = document.getElementById(`state-session-form-${uuid}`).href;
    const allCards = document.querySelectorAll('#cards-container div');
    allCards.forEach(card => {
        card.style.background = '';
    });
    element.style.background = '#FFFBEB';
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest', // Indica que es una petición AJAX
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la petición: ${response.statusText}`);
            }
            return response.json(); // Supone que el servidor devuelve JSON
        })
        .then(data => {
            const dashboardContent = document.getElementById('dashboard-content');
            if (dashboardContent) {
                dashboardContent.innerHTML = data.html; // Actualiza el contenido dinámicamente
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
