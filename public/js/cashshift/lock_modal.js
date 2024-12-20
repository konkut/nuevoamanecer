"use strict";

/*MODAL DELETE*/
const openLockModal = (id, name) => {
    document.getElementById("lock-modal-" + id).classList.remove("hidden");
    document.getElementById("name-lock-" + id).innerText = name;
};
const closeLockModal = (id) => {
    document.getElementById("lock-modal-" + id).classList.add("hidden");
};



