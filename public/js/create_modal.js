"use strict";
function open_create_modal(view) {
    const modal = document.getElementById(`create-modal-${view}`);
    const modal_scale = document.getElementById(`scale-modal-${view}`);
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
    first_focus_create(view);
}

function close_create_modal(view) {
    const modal = document.getElementById(`create-modal-${view}`);
    const modal_scale = document.getElementById(`scale-modal-${view}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
}



