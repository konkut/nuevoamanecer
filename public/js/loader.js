const loader_action_status = (status) => {
    const loader_action = document.getElementById("loader_action");
    if (status == "show") {
        loader_action.style.display = "flex";
        loader_action.classList.remove("loader_action_animation_hide");
        loader_action.classList.add("loader_action_animation_show");
        loader_action.classList.add("scale_animation");
    }

    if (status == "hide") {
        document
            .getElementsByTagName("body")[0]
            .style.removeProperty("overflow");
        loader_action.style.display = "none";
        loader_action.classList.add("loader_action_animation_hide");
        loader_action.classList.remove("loader_action_animation_show");
        loader_action.classList.remove("scale_animation");
    }
};
