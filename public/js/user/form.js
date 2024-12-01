"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
  let email_icon = document.getElementById("email_icon");
  let password_icon = document.getElementById("password_icon");
    let name = document.getElementById("name");

    /*FOCUS AND BLUR ICON*/
    name_icon.style.color = "#60A5FA";
    name.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#email")) {
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
            if (e.target.matches("#name")) {
                name_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#email")) {
                email_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#password")) {
                password_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
