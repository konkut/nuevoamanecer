"use strict";

/*MODAL DELETE*/
const open_disable_modal = (uuid, name) => {
    const modal = document.getElementById(`disable-modal-${uuid}`);
    const title = document.getElementById(`disable-name-${uuid}`);
    const modal_scale = document.getElementById(`scale-disable-${uuid}`);
    title.innerText = name;
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
};
const close_disable_modal = (uuid) => {
    const modal = document.getElementById(`disable-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-disable-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
};

const open_enable_modal = (uuid, name) => {
    const modal = document.getElementById(`enable-modal-${uuid}`);
    const title = document.getElementById(`enable-name-${uuid}`);
    const modal_scale = document.getElementById(`scale-enable-${uuid}`);
    title.innerText = name;
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
};
const close_enable_modal = (uuid) => {
    const modal = document.getElementById(`enable-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-enable-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
};



