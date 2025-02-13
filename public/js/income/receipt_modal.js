"use strict"
const open_receipt_modal = (uuid, name) => {
    const modal = document.getElementById(`receipt-modal-${uuid}`);
    const title = document.getElementById(`receipt-name-${uuid}`);
    const modal_scale = document.getElementById(`scale-receipt-${uuid}`);
    title.innerText = name;
    modal.classList.add("blur-sm");
    modal.classList.add("md_alert_animation_show");
    modal_scale.classList.add('scale_animation');
    modal.classList.remove('hidden');
    modal.classList.remove("md_alert_animation_hide");
};
const close_receipt_modal = (uuid) => {
    const modal = document.getElementById(`receipt-modal-${uuid}`);
    const modal_scale = document.getElementById(`scale-receipt-${uuid}`);
    modal.classList.remove("blur-sm");
    modal.classList.remove("md_alert_animation_show");
    modal_scale.classList.remove('scale_animation');
    modal.classList.add('hidden');
    modal.classList.add("md_alert_animation_hide");
};



