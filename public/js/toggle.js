"use strict";
const toggleStatus = () => {

    const statusText = document.getElementById("toggleStatus");
    const toggleButton = document.getElementById("toggleButton");
    const hiddenInput = document.getElementById("status");
    const toggleCircle = toggleButton.querySelector("div");

    // Cambia el estado del toggle
    if (hiddenInput.value === "1") {
        hiddenInput.value = "0"; // Cambia a Off
        statusText.innerText = "Off";
        statusText.classList.remove("text-green-500");
        statusText.classList.add("text-red-500");
        toggleButton.classList.remove("bg-green-500");
        toggleButton.classList.add("bg-red-500");
        toggleCircle.classList.remove("translate-x-6", "bg-green-600");
        toggleCircle.classList.add("bg-red-600");
    } else {
        hiddenInput.value = "1"; // Cambia a On
        statusText.innerText = "On";
        statusText.classList.remove("text-red-500");
        statusText.classList.add("text-green-500");
        toggleButton.classList.remove("bg-red-500");
        toggleButton.classList.add("bg-green-500");
        toggleCircle.classList.add("translate-x-6", "bg-green-600");
        toggleCircle.classList.remove("bg-red-600");
    }
};



