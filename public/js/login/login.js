"use strict";
(() => {
    let email_input = document.getElementById("email");
    let email_icon = document.getElementById("email_icon");
    let password_input = document.getElementById("password");
    let password_icon = document.getElementById("password_icon");

    document.addEventListener("DOMContentLoaded", () => {
        email_icon.style.color = "#60A5FA";
    });
    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#password")) {
                password_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#password")) {
                password_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
