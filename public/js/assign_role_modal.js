"use strict";

const openRoleModal=(userId)=> {
    document.getElementById("role-modal-" + userId).classList.remove("hidden");
}

const closeRoleModal=(userId)=> {
    document.getElementById("role-modal-" + userId).classList.add("hidden");
}