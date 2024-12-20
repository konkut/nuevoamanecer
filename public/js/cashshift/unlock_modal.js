"use strict";

/*MODAL DELETE*/
const openUnlockModal = (id, name) => {
    document.getElementById("unlock-modal-" + id).classList.remove("hidden");
    document.getElementById("name-unlock-" + id).innerText = name;
};
const closeUnlockModal = (id) => {
    document.getElementById("unlock-modal-" + id).classList.add("hidden");
};



