const icon_shields = document.querySelectorAll(".icon-shield");
const box_shields = document.querySelectorAll(".box-shield");
icon_shields.forEach((icon_shield, index) => {
    const box_shield = box_shields[index];
    icon_shield.addEventListener("mouseover", () => {
        box_shield.classList.remove('hidden');
    });
    icon_shield.addEventListener("mouseout", () => {
        box_shield.classList.add('hidden');
    });
});
