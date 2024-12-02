"use strict";

(() => {
    let opening_icon = document.getElementById("opening_icon");
    let opening = document.getElementById("opening");

    /*FOCUS AND BLUR ICON*/
    opening_icon.style.color = "#60A5FA";
    opening.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#opening")) {
                opening_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#opening")) {
                opening_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
