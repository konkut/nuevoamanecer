"use strict";

(() => {
  let email_icon = document.getElementById("email_icon");
  
    document.addEventListener("DOMContentLoaded", () => {
        email_icon.style.color = "#2563eb";
    });
    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#2563eb";
            } 
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#email")) {
                email_icon.style.color = "#374151";
            } 
        },
        true
    );
   
})();


