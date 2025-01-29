"use strict";
const change_state_password = (show_password) => {
    let target = show_password.getAttribute("data-target");
    let status = show_password.getAttribute("data-state");
    let input_password = document.getElementById(target);
    if (status === "hide") {
        input_password.setAttribute("type", "text");
        show_password.innerHTML = lang["hide_password"]; // Traducción para "Ocultar contraseña"
        show_password.setAttribute("data-state", "show");
    } else if (status === "show") {
        input_password.setAttribute("type", "password");
        show_password.innerHTML = lang["show_password"]; // Traducción para "Mostrar contraseña"
        show_password.setAttribute("data-state", "hide");
    }
};


