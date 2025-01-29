let md_alert_dom;
let md_alert_btn_close;
let md_alert_content;
let md_alert_inside;
let md_alert_footer_other_btns;
const base = location.protocol + "//" + location.host;
document.addEventListener('DOMContentLoaded',(e)=>{
    md_alert_dom = document.getElementById("md_alert_dom");
    md_alert_inside = document.getElementById("md_alert_inside");
    md_alert_btn_close = document.getElementById("md_alert_btn_close");
    md_alert_content = document.getElementById("md_alert_content");
    md_alert_footer_other_btns = document.getElementById("md_alert_footer_other_btns");
    if(md_alert_btn_close){
        md_alert_btn_close.addEventListener("click",(e)=>{
            e.preventDefault();
            md_alert_status("hide");
        })
    }
});
function mdalert(data){
    md_alert_content.innerHTML="";
    if(data){
        if(data.title) title = data.title;
        else title = "MD Alert";
        let content = "";
        content +=  `<h2 class="block text-base font-bold m-0 pb-0 text-center w-full">${title}</h2>`;
        if(data.type) content += `<div class="block text-center w-full mt-4">
                                    <img class='block my-0 mx-auto' width="120" height="120" src="${base}/images/icon/${data.type}.png" alt="imagen">
                                 </div>`;
        if(data.msg) msg = data.msg;
        else msg = "Error desconocido";
        content += `<h5 class="block text-sm font-medium m-0 pb-0 text-center w-full mt-4">${msg}</h5>`
        if(data.msgs){
            messages = JSON.parse(data.msgs);
            if(messages.length > 0){
                content += "<ul class='m-0 mt-4 p-0 text-center'>";
                messages.forEach((element,index)=>{
                    content += `<li style="font-size: 14px;"><i style="margin-right: 1px; color: red;" class='bi bi-bullseye'></i>&nbsp;&nbsp;${element}</li>`;
                })
                content += "</ul>";
            }
        }
        let actions_btns = "";
        if(data.actions){
            actions = JSON.parse(data.actions);
            if(actions.length > 0){
                actions.forEach((element,index)=>{
                    if(element.url) actions_btns += `<a href="${element.url}" class="px-4 py-2 bg-${element.type}-500 text-white hover:bg-${element.type}-600 rounded-lg border-0 block text-center w-3/4 mx-auto mb-4 shadow-xl uppercase text-white">${element.name}</a>`;
                    else actions_btns += `<a href="#" onclick="${element.callback}(${element.params}); return false;" class="px-4 py-2 bg-${element.type}-500 text-white hover:bg-${element.type}-600 rounded-lg border-0 block text-center w-3/4 mx-auto mb-4 shadow-xl uppercase text-white">${element.name}</a>`;
                })
            }
        }
        if(data.additional) {
            additional = JSON.parse(data.additional);
            if(additional.hideclose) md_alert_btn_close.style.display = 'none';
        }
        md_alert_footer_other_btns.innerHTML=actions_btns;
        md_alert_content.innerHTML=content;
        md_alert_status("show");
    }
};
function md_alert_status(status){
    if(status == "show") {
        document.getElementsByTagName("body")[0].style.overflow = "hidden";
        document.getElementsByClassName("wrapper")[0].classList.add("blur-sm");
        md_alert_dom.style.display = "flex";
        md_alert_dom.classList.remove("md_alert_animation_hide");
        md_alert_dom.classList.add("md_alert_animation_show");
        md_alert_inside.classList.add('scale_animation');
    }
    if(status == "hide") {
        document.getElementsByTagName("body")[0].style.removeProperty("overflow");
        document.getElementsByClassName("wrapper")[0].classList.remove("blur-sm");
        md_alert_dom.style.display = "none";
        md_alert_dom.classList.add("md_alert_animation_hide");
        md_alert_dom.classList.remove("md_alert_animation_show");
        md_alert_inside.classList.remove('scale_animation');
    }
};
