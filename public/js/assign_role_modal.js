"use strict";

const openRoleModal=(uuid)=> {
    const modal = document.getElementById(`role-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-rol-${uuid}`);
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
}

const closeRoleModal=(uuid)=> {
    const modal = document.getElementById(`role-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-rol-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
}
