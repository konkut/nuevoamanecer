"use strict";
function openDetailsModal(uuid) {
    const modal = document.getElementById(`details-modal-${uuid}`);
    modal.classList.remove('hidden');
}

function closeDetailsModal(uuid) {
    const modal = document.getElementById(`details-modal-${uuid}`);
    modal.classList.add('hidden');
}



