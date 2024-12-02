"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
    let amount_icon = document.getElementById("amount_icon");
    let commission_icon = document.getElementById("commission_icon");
    let observation_icon = document.getElementById("observation_icon");
    let servicewithoutprice_uuid_icon = document.getElementById("servicewithoutprice_uuid_icon");
    let transactionmethod_uuid_icon = document.getElementById("transactionmethod_uuid_icon");

    let name = document.getElementById("name");
    /*FOCUS AND BLUR ICON*/
    name_icon.style.color = "#60A5FA";
    name.focus();

    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#60A5FA";
            }else if (e.target.matches("#observation")) {
                observation_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#servicewithoutprice_uuid")) {
                servicewithoutprice_uuid_icon.style.color = "#60A5FA";
            }else if (e.target.matches("#transactionmethod_uuid")) {
                transactionmethod_uuid_icon.style.color = "#60A5FA";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#d1d5db";
            }else if (e.target.matches("#observation")) {
                observation_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#servicewithoutprice_uuid")) {
                servicewithoutprice_uuid_icon.style.color = "#d1d5db";
            }else if (e.target.matches("#transactionmethod_uuid")) {
                transactionmethod_uuid_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
