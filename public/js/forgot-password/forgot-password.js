"use strict";

(() => {
  let email_icon = document.getElementById("email_icon");

    document.addEventListener("DOMContentLoaded", () => {
        email_icon.style.color = "#60A5FA";
    });
    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#d1d5db";
            }
        },
        true
    );

})();


