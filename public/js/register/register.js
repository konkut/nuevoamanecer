"use strict";

(() => {
    let email_icon = document.getElementById("email_icon");
    let password_icon = document.getElementById("password_icon");
    let name_icon = document.getElementById("name_icon");
    let password_confirmation_icon = document.getElementById(
        "password_confirmation_icon"
    );

    let email_input = document.getElementById("email");
    let password_input = document.getElementById("password");
    let name_input = document.getElementById("name");
    let password_confirmation_input = document.getElementById(
        "password_confirmation"
    );
  
  document.addEventListener("DOMContentLoaded", () => {
      name_icon.style.color = "#2563eb"; 
  });
  document.addEventListener(
      "focus",
      (e) => {
          if (e.target.matches("#name")) {
              name_icon.style.color = "#2563eb";
          } else if (e.target.matches("#email")) {
              email_icon.style.color = "#2563eb";
          } else if (e.target.matches("#password")) {
              password_icon.style.color = "#2563eb";
          } else if (e.target.matches("#password_confirmation")) {
              password_confirmation_icon.style.color = "#2563eb";
          }
      },
      true
  );

   document.addEventListener(
       "blur",
       (e) => {
           if (e.target.matches("#name")) {
               name_icon.style.color = "#374151";
           } else if (e.target.matches("#email")) {
               email_icon.style.color = "#374151";
           } else if (e.target.matches("#password")) {
               password_icon.style.color = "#374151";
           } else if (e.target.matches("#password_confirmation")) {
               password_confirmation_icon.style.color = "#374151";
           }
       },
       true
   );
})();

