"use strict";

/*MODAL DELETE*/
const openBoxModal = (id, name) => {
    document.getElementById("modal-box-" + id).classList.remove("hidden");
    document.getElementById("name-box-" + id).innerText = name;
};
const closeBoxModal = (id) => {
    document.getElementById("modal-box-" + id).classList.add("hidden");
};



