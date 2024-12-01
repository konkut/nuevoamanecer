"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
    let description_icon = document.getElementById("description_icon");
    let amount_icon = document.getElementById("amount_icon");
    let commission_icon = document.getElementById("commission_icon");
    /*let currency_uuid_icon = document.getElementById("currency_uuid_icon");*/
    let category_uuid_icon = document.getElementById("category_uuid_icon");
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
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#60A5FA";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#60A5FA";
            } /*else if (e.target.matches("#currency_uuid")) {
                currency_uuid_icon.style.color = "#2563eb";
            } */else if (e.target.matches("#category_uuid")) {
                category_uuid_icon.style.color = "#60A5FA";
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
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#d1d5db";
            } else if (e.target.matches("#commission")) {
                commission_icon.style.color = "#d1d5db";
            } /*else if (e.target.matches("#currency_uuid")) {
                currency_uuid_icon.style.color = "#374151";
            } */ else if (e.target.matches("#category_uuid")) {
                category_uuid_icon.style.color = "#d1d5db";
            }
        },
        true
    );
})();
