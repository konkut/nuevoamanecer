"use strict";

/*MODAL DELETE*/
const openModal = (uuid, name) => {
    const modal = document.getElementById(`modal-${uuid}`);
    const title = document.getElementById(`name-${uuid}`);
    const modal_scale = document.getElementById(`scale-delete-${uuid}`);
    title.innerText = name;
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
};
const closeModal = (uuid) => {
    const modal = document.getElementById(`modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-delete-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
};



