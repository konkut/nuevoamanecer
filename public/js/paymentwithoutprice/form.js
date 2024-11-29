"use strict";

(() => {
   
    let observation_icon = document.getElementById("observation_icon");
    let servicewithprice_icon = document.getElementById("servicewithprice_icon");
    let transactionmethod_icon = document.getElementById("transactionmethod_icon");
    
    let observation = document.getElementById("observation");
    /*FOCUS AND BLUR ICON*/
    observation_icon.style.color = "#2563eb";
    observation.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#observation")) {
                observation_icon.style.color = "#2563eb";
            } else if (e.target.matches("#servicewithprice")) {
                servicewithprice_icon.style.color = "#2563eb";
            } else if (e.target.matches("#transactionmethod")) {
                transactionmethod_icon.style.color = "#2563eb";
            } 
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#observation")) {
                observation_icon.style.color = "#374151";
            } else if (e.target.matches("#servicewithprice")) {
                servicewithprice_icon.style.color = "#374151";
            } else if (e.target.matches("#transactionmethod")) {
                transactionmethod_icon.style.color = "#374151";
            }
        },
        true
    );
})();
