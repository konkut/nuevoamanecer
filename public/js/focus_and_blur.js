
document.addEventListener("DOMContentLoaded", () => {
    const firsElement = document.querySelector(".first-element");
    if (firsElement) {
        firsElement.focus();
        const icon = firsElement.previousElementSibling;
        if (icon && icon.tagName === "I") {
            icon.style.color = "#60A5FA";
        }
    }
    document.addEventListener("focus", (event) => {
        if (event.target.matches(".focus-and-blur")) {
            const icon = event.target.previousElementSibling;
            if (icon && icon.tagName === "I") {
                icon.style.color = "#60A5FA";
            }
        }
    }, true);
    document.addEventListener("blur", (event) => {
        if (event.target.matches(".focus-and-blur")) {
            const icon = event.target.previousElementSibling;
            if (icon && icon.tagName === "I") {
                icon.style.color = "#d1d5db";
            }
        }
    }, true);
});
