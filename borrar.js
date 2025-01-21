class="cursor-default text-center w-full sm:w-20 px-3 py-1 mt-1 font-bold text-lime-800 bg-lime-300 border border-lime-100 rounded-lg shadow-md hover:bg-lime-400 active:bg-lime-500 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-lime-300 focus:ring-offset-2 transition-all ease-in-out"



    $validator->after(function ($validator) use ($request) {
    $balances = [];
    foreach ($request->transactionmethod_uuids as $key => $transactionmethod_uuid) {
        $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->select('balance', 'name')->first();
        $product = Product::where('product_uuid', $request->product_uuids[$key] )->select('price', 'name')->first();
        if ($transactionmethod && $product) {
            if (!isset($balances[$transactionmethod->name])) {
                $balances[$transactionmethod->name] = [
                    'balance' => $transactionmethod->balance,
                    'requested' => 0,
            ];
            }
            $quantity = $request->quantities[$key] ?? 0;
            $amount = $quantity * $product->price;
            $balances[$transactionmethod->name]['requested'] += $amount;
            if ($amount > $transactionmethod->balance && $transactionmethod->name !== "EFECTIVO") {
                $validator->errors()->add('transactionmethod_uuids',__("El saldo disponible en {$transactionmethod->name} no es suficiente. Solicitado: Bs. {$amount}, Disponible: Bs. {$transactionmethod->balance}"));
                return;
            }
        } else {
            $validator->errors()->add('transactionmethod_uuids',__("El método de transacción {$transactionmethod->name} no fue encontrado."));
        }
    }
    foreach ($balances as $name => $data) {
        if ($data['requested'] > $data['balance'] && $name !== "EFECTIVO") {
            $validator->errors()->add('transactionmethod_uuids',__("El saldo total disponible en {$name} no es suficiente. Solicitado: Bs. {$data['requested']}, Disponible: Bs. {$data['balance']}"));
        }
    }
});




"use strict";

(() => {
    let name_icon = document.getElementById("name_icon");
    let description_icon = document.getElementById("description_icon");
    let amount_icon = document.getElementById("amount_icon");
    let category_icon = document.getElementById("category_icon");
    let is_active_icon = document.getElementById("is_active_icon");
    let name = document.getElementById("name");

    /*FOCUS AND BLUR ICON*/
    document.addEventListener("DOMContentLoaded", () => {
        name_icon.style.color = "#2563eb";
        name.focus();
    });
    document.addEventListener(
        "focus",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#2563eb";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#2563eb";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#2563eb";
            } else if (e.target.matches("#category")) {
                category_icon.style.color = "#2563eb";
            } else if (e.target.matches("#is_active")) {
                is_active_icon.style.color = "#2563eb";
            }
        },
        true
    );

    document.addEventListener(
        "blur",
        (e) => {
            if (e.target.matches("#name")) {
                name_icon.style.color = "#374151";
            } else if (e.target.matches("#description")) {
                description_icon.style.color = "#374151";
            } else if (e.target.matches("#amount")) {
                amount_icon.style.color = "#374151";
            } else if (e.target.matches("#category")) {
                category_icon.style.color = "#374151";
            } else if (e.target.matches("#is_active")) {
                is_active_icon.style.color = "#374151";
            }
        },
        true
    );

    /*REQUEST AXIOS */
    let form_service_create = document.getElementById("form_service_create");
    if (form_service_create) {
        form_service_create.addEventListener("submit", (e) => {
            e.preventDefault();
            services();
        });
    }

    let form_service_update = document.getElementById("form_service_update");
    if (form_service_update) {
        form_service_update.addEventListener("submit", (e) => {
            e.preventDefault();
            services();
        });
    }

    /*CLOSE ALERT */
    let md_alert_btn_close = document.getElementById("md_alert_btn_close");
    let md_alert_content = document.getElementById("md_alert_content");
    if (md_alert_btn_close) {
        md_alert_btn_close.addEventListener("click", (e) => {
            e.preventDefault();
            alert_status("hide");
        });
    }
})();

const services = () => {
    const csrftoken = document
        .getElementsByName("csrf-token")[0]
        .getAttribute("content");
    const app_name = "Nuevo Amanecer";
    const url = location.protocol + "//" + location.host + "/api/service";
    const bodyFormData = new FormData(form_service_create);

    loader_action_status("show");

    const request_data_service = async () => {
        try {
            const request = await axios({
                method: "post",
                url: url,
                data: bodyFormData,
                headers: { "X-CSRF-TOKEN": csrftoken },
            });
            loader_action_status("hide");
            if (request.data.type == "error") {
                alert(request.data);
            }
            if (request.data.type == "success") {
                const inputs = form_service_create.querySelectorAll("input");
                inputs.forEach((input) => {
                    input.value = "";
                });
                alert(request.data);
            }
        } catch (e) {
            loader_action_status("hide");
            alert({ title: app_name, type: "error", msg: lang["error"] });
        }
    };
    request_data_service();
};



const alert = (data) => {
    let content = "";
    let title = "";
    let msg = "";
    let msgs;

    md_alert_content.innerHTML = "";
    if (data) {
        if (data.title) title = data.title;
        else title = "Alerta desconocida";
        content += `<h2 class="text-base font-bold text-center">${title}</h2>`;

        if (data.type)
            content += `<div class="flex justify-center mt-4"><img class='w-20' src="${
                location.protocol + "//" + location.host
            }/images/icon/${data.type}.png" alt=""></div>`;

        if (data.msg) msg = data.msg;
        else msg = "Error desconocido";
        content += `<h4 class="text-sm font-medium text-center mt-4">${msg}</h4>`;

        if (data.msgs) {
            //data.msgs value stringify
            msgs = JSON.parse(data.msgs); //messages value object
            if (msgs.length > 0) {
                content += "<ul class='mt-4 text-center'>";
                msgs.forEach((element, index) => {
                    content += `<li class="text-base"><span class="text-xs">❌</span> &nbsp;&nbsp;${element}</li>`;
                });
                content += "</ul>";
            }
        }

        md_alert_content.innerHTML = content;
        alert_status("show");
    }
};

function alert_status(status) {
    if (status == "show") {
        document.getElementsByTagName("body")[0].style.overflow = "hidden";
        md_alert_dom.style.display = "flex";
        md_alert_dom.classList.remove("md_alert_animation_hide");
        md_alert_dom.classList.add("md_alert_animation_show");
        md_alert_inside.classList.add("scale_animation");
    }
    if (status == "hide") {
        document
            .getElementsByTagName("body")[0]
            .style.removeProperty("overflow");
        md_alert_dom.style.display = "none";
        md_alert_dom.classList.add("md_alert_animation_hide");
        md_alert_dom.classList.remove("md_alert_animation_show");
        md_alert_inside.classList.remove("scale_animation");
    }
}

/*SEARCH TABLE LIST */
const enableSearch = (th, placeholder) => {
    if (th.querySelector("input")) return;
    // Guardar el contenido original
    const originalContent = th.innerHTML;
    // Crear contenedor para controlar el tamaño del input
    const container = document.createElement("div");
    container.className = "flex justify-center items-center w-full";
    // Crear input de búsqueda con un ancho fijo y estilo
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Buscar " + placeholder;
    input.className =
        "border border-gray-300 rounded-full px-2 py-1 w-24 text-xs text-gray-700 focus:ring-2 focus:ring-blue-400";
    input.style.textAlign = "center";
    // Reemplazar contenido del encabezado por el contenedor con el input
    th.innerHTML = ""; // Limpia el contenido
    container.appendChild(input);
    th.appendChild(container);
    input.focus(); // Enfoca el input para buscar de inmediato
    // Agregar evento para filtrar al escribir
    input.addEventListener("keyup", function () {
        filterTable(Array.from(th.parentNode.children).indexOf(th), this.value);
    });
    // Al perder el foco, restaurar el contenido original
    input.addEventListener("blur", function () {
        th.innerHTML = originalContent;

    });
};

// SEARCH
const filterTable = (columnIndex, searchValue) => {
    const table = document.querySelector("table");
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach((row) => {
        const cell = row.querySelectorAll("td")[columnIndex - 1]; // Ajusta el índice para comenzar desde 0
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            row.style.display =
                textValue.toLowerCase().indexOf(searchValue.toLowerCase()) > -1
                    ? ""
                    : "none";
        }
    });
};
