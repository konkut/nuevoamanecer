"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
    let description_icon = document.getElementById("description_icon");
    let name = document.getElementById("name");

    /*FOCUS AND BLUR ICON*/
    name_icon.style.color = "#2563eb";
    name.focus();
  
    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#2563eb";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#2563eb";
            } 
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#374151";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#374151";
            } 
        },
        true
    );
})();