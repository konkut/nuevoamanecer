"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
    let description_icon = document.getElementById("description_icon");
    let name = document.getElementById("name");

    /*FOCUS AND BLUR ICON*/
    name_icon.style.color = "#60A5FA";
    name.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
