"use strict";

(() => {
    let observation_icon = document.getElementById("observation_icon");
    let servicewithprice_uuid_icon = document.getElementById("servicewithprice_uuid_icon");
    let transactionmethod_uuid_icon = document.getElementById("transactionmethod_uuid_icon");

    let observation = document.getElementById("observation");
    /*FOCUS AND BLUR ICON*/
    observation_icon.style.color = "#60A5FA";
    observation.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#observation")) {
                observation_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#servicewithprice_uuid")) {
                servicewithprice_uuid_icon.style.color = "#60A5FA";
            }else if (e.target.matches("#transactionmethod_uuid")) {
                transactionmethod_uuid_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#observation")) {
                observation_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#servicewithprice_uuid")) {
                servicewithprice_uuid_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#transactionmethod_uuid")) {
                transactionmethod_uuid_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
