"use strict";

/*MODAL DELETE*/
const openModal = (id, name) => {
    document.getElementById("modal-" + id).classList.remove("hidden");
    document.getElementById("name-" + id).innerText = name;
};
const closeModal = (id) => {
    document.getElementById("modal-" + id).classList.add("hidden");
};



