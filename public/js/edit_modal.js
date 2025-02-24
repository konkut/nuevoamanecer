"use strict";
function open_edit_modal(uuid) {
    const modal = document.getElementById(`edit-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-edit-${uuid}`);
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
}
function close_edit_modal(uuid) {
    const modal = document.getElementById(`edit-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-edit-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
}



