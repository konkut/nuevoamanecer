"use strict";

(() => {
  let show_password = document.getElementsByClassName("show_password");
  if (show_password) {
      for (let i = 0; i < show_password.length; i++) {
          show_password[i].addEventListener("click", (e) => {
              show_password_login(show_password[i]);
          });
      }
  }
})();

//Show password field login function
const show_password_login = (show_password) => {
    let target = show_password.getAttribute("data-target");
    let status = show_password.getAttribute("data-state");
    let input_password = document.getElementById(target);
    if (status == "hide") {
        input_password.setAttribute("type", "text");
        show_password.innerHTML = lang["hide_password"]; /*AQUI*/
        show_password.setAttribute("data-state", "show");
    }
    if (status == "show") {
        input_password.setAttribute("type", "password");
        show_password.innerHTML = lang["show_password"];
        show_password.setAttribute("data-state", "hide");
    }
};

