"use strict";
function openDetailsModal(uuid) {
    const modal = document.getElementById(`details-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-modal-${uuid}`);
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
}

function closeDetailsModal(uuid) {
    const modal = document.getElementById(`details-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-modal-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
}



