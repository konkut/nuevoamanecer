async function fetchDetails(uuid) {
    loader_action_status('show');
    const form = document.getElementById(`details-form-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        loader_action_status('hide');
        if (!response.ok) {
            const data = await response.json();
            mdalert({
                title: data?.title || lang["error_title"],
                type: data?.type || lang["error_subtitle"],
                msg: data?.msg || lang["error_request"],
            });
            return;
        }
        const data = await response.json();
        if (document.querySelector(`#modal-show-${uuid}`)) {
            document.querySelector(`#initial-balance-bill-200-${uuid}`).textContent = data.denomination.bill_200 ?? 0;
            document.querySelector(`#initial-balance-bill-100-${uuid}`).textContent = data.denomination.bill_100 ?? 0;
            document.querySelector(`#initial-balance-bill-50-${uuid}`).textContent = data.denomination.bill_50 ?? 0;
            document.querySelector(`#initial-balance-bill-20-${uuid}`).textContent = data.denomination.bill_20 ?? 0;
            document.querySelector(`#initial-balance-bill-10-${uuid}`).textContent = data.denomination.bill_10 ?? 0;
            document.querySelector(`#initial-balance-coin-5-${uuid}`).textContent = data.denomination.coin_5 ?? 0;
            document.querySelector(`#initial-balance-coin-2-${uuid}`).textContent = data.denomination.coin_2 ?? 0;
            document.querySelector(`#initial-balance-coin-1-${uuid}`).textContent = data.denomination.coin_1 ?? 0;
            document.querySelector(`#initial-balance-coin-0-5-${uuid}`).textContent = data.denomination.coin_0_5 ?? 0;
            document.querySelector(`#initial-balance-coin-0-2-${uuid}`).textContent = data.denomination.coin_0_2 ?? 0;
            document.querySelector(`#initial-balance-coin-0-1-${uuid}`).textContent = data.denomination.coin_0_1 ?? 0;
            document.querySelector(`#initial-balance-total-${uuid}`).textContent = data.denomination.total ?? 0;
        }
        if (document.querySelector(`#initial-balance-physical-${uuid}`)){
            document.querySelector(`#initial-balance-physical-${uuid}`).textContent = data.denomination.physical_cash ?? 0;
        }
        if (document.querySelector(`#initial-balance-digital-${uuid}`)){
            document.querySelector(`#initial-balance-digital-${uuid}`).textContent = data.denomination.digital_cash ?? 0;
        }
        if (document.querySelector(`#show-incomes-modal-${uuid}`)) {
            document.querySelector(`#incomes-balance-bill-200-${uuid}`).textContent = data.denomination_incomes.bill_200 ?? 0;
            document.querySelector(`#incomes-balance-bill-100-${uuid}`).textContent = data.denomination_incomes.bill_100 ?? 0;
            document.querySelector(`#incomes-balance-bill-50-${uuid}`).textContent = data.denomination_incomes.bill_50 ?? 0;
            document.querySelector(`#incomes-balance-bill-20-${uuid}`).textContent = data.denomination_incomes.bill_20 ?? 0;
            document.querySelector(`#incomes-balance-bill-10-${uuid}`).textContent = data.denomination_incomes.bill_10 ?? 0;
            document.querySelector(`#incomes-balance-coin-5-${uuid}`).textContent = data.denomination_incomes.coin_5 ?? 0;
            document.querySelector(`#incomes-balance-coin-2-${uuid}`).textContent = data.denomination_incomes.coin_2 ?? 0;
            document.querySelector(`#incomes-balance-coin-1-${uuid}`).textContent = data.denomination_incomes.coin_1 ?? 0;
            document.querySelector(`#incomes-balance-coin-0-5-${uuid}`).textContent = data.denomination_incomes.coin_0_5 ?? 0;
            document.querySelector(`#incomes-balance-coin-0-2-${uuid}`).textContent = data.denomination_incomes.coin_0_2 ?? 0;
            document.querySelector(`#incomes-balance-coin-0-1-${uuid}`).textContent = data.denomination_incomes.coin_0_1 ?? 0;
            document.querySelector(`#incomes-balance-total-${uuid}`).textContent = parseFloat(data.denomination_incomes.total).toFixed(2) ?? 0;
        }
        if (document.querySelector(`#show-expenses-modal-${uuid}`)) {
            document.querySelector(`#expenses-balance-bill-200-${uuid}`).textContent = data.denomination_expenses.bill_200 ?? 0;
            document.querySelector(`#expenses-balance-bill-100-${uuid}`).textContent = data.denomination_expenses.bill_100 ?? 0;
            document.querySelector(`#expenses-balance-bill-50-${uuid}`).textContent = data.denomination_expenses.bill_50 ?? 0;
            document.querySelector(`#expenses-balance-bill-20-${uuid}`).textContent = data.denomination_expenses.bill_20 ?? 0;
            document.querySelector(`#expenses-balance-bill-10-${uuid}`).textContent = data.denomination_expenses.bill_10 ?? 0;
            document.querySelector(`#expenses-balance-coin-5-${uuid}`).textContent = data.denomination_expenses.coin_5 ?? 0;
            document.querySelector(`#expenses-balance-coin-2-${uuid}`).textContent = data.denomination_expenses.coin_2 ?? 0;
            document.querySelector(`#expenses-balance-coin-1-${uuid}`).textContent = data.denomination_expenses.coin_1 ?? 0;
            document.querySelector(`#expenses-balance-coin-0-5-${uuid}`).textContent = data.denomination_expenses.coin_0_5 ?? 0;
            document.querySelector(`#expenses-balance-coin-0-2-${uuid}`).textContent = data.denomination_expenses.coin_0_2 ?? 0;
            document.querySelector(`#expenses-balance-coin-0-1-${uuid}`).textContent = data.denomination_expenses.coin_0_1 ?? 0;
            document.querySelector(`#expenses-balance-total-${uuid}`).textContent = parseFloat(data.denomination_expenses.total).toFixed(2) ?? 0;
        }
        if (document.querySelector(`#show-closing-modal-${uuid}`)) {
            document.querySelector(`#closing-balance-bill-200-${uuid}`).textContent = data.denomination_closing.bill_200 ?? 0;
            document.querySelector(`#closing-balance-bill-100-${uuid}`).textContent = data.denomination_closing.bill_100 ?? 0;
            document.querySelector(`#closing-balance-bill-50-${uuid}`).textContent = data.denomination_closing.bill_50 ?? 0;
            document.querySelector(`#closing-balance-bill-20-${uuid}`).textContent = data.denomination_closing.bill_20 ?? 0;
            document.querySelector(`#closing-balance-bill-10-${uuid}`).textContent = data.denomination_closing.bill_10 ?? 0;
            document.querySelector(`#closing-balance-coin-5-${uuid}`).textContent = data.denomination_closing.coin_5 ?? 0;
            document.querySelector(`#closing-balance-coin-2-${uuid}`).textContent = data.denomination_closing.coin_2 ?? 0;
            document.querySelector(`#closing-balance-coin-1-${uuid}`).textContent = data.denomination_closing.coin_1 ?? 0;
            document.querySelector(`#closing-balance-coin-0-5-${uuid}`).textContent = data.denomination_closing.coin_0_5 ?? 0;
            document.querySelector(`#closing-balance-coin-0-2-${uuid}`).textContent = data.denomination_closing.coin_0_2 ?? 0;
            document.querySelector(`#closing-balance-coin-0-1-${uuid}`).textContent = data.denomination_closing.coin_0_1 ?? 0;
            document.querySelector(`#closing-balance-total-${uuid}`).textContent = parseFloat(data.denomination_closing.total).toFixed(2) ?? 0;
        }
        if (document.querySelector(`#show-physical-modal-${uuid}`)) {
            document.querySelector(`#physical-balance-bill-200-${uuid}`).textContent = data.denomination_physical.bill_200 ?? 0;
            document.querySelector(`#physical-balance-bill-100-${uuid}`).textContent = data.denomination_physical.bill_100 ?? 0;
            document.querySelector(`#physical-balance-bill-50-${uuid}`).textContent = data.denomination_physical.bill_50 ?? 0;
            document.querySelector(`#physical-balance-bill-20-${uuid}`).textContent = data.denomination_physical.bill_20 ?? 0;
            document.querySelector(`#physical-balance-bill-10-${uuid}`).textContent = data.denomination_physical.bill_10 ?? 0;
            document.querySelector(`#physical-balance-coin-5-${uuid}`).textContent = data.denomination_physical.coin_5 ?? 0;
            document.querySelector(`#physical-balance-coin-2-${uuid}`).textContent = data.denomination_physical.coin_2 ?? 0;
            document.querySelector(`#physical-balance-coin-1-${uuid}`).textContent = data.denomination_physical.coin_1 ?? 0;
            document.querySelector(`#physical-balance-coin-0-5-${uuid}`).textContent = data.denomination_physical.coin_0_5 ?? 0;
            document.querySelector(`#physical-balance-coin-0-2-${uuid}`).textContent = data.denomination_physical.coin_0_2 ?? 0;
            document.querySelector(`#physical-balance-coin-0-1-${uuid}`).textContent = data.denomination_physical.coin_0_1 ?? 0;
            document.querySelector(`#physical-balance-total-${uuid}`).textContent = parseFloat(data.denomination_physical.total).toFixed(2) ?? 0;
        }
        if (document.querySelector(`#show-difference-modal-${uuid}`)) {
            document.querySelector(`#difference-balance-bill-200-${uuid}`).textContent = data.denomination_difference.bill_200 ?? 0;
            document.querySelector(`#difference-balance-bill-100-${uuid}`).textContent = data.denomination_difference.bill_100 ?? 0;
            document.querySelector(`#difference-balance-bill-50-${uuid}`).textContent = data.denomination_difference.bill_50 ?? 0;
            document.querySelector(`#difference-balance-bill-20-${uuid}`).textContent = data.denomination_difference.bill_20 ?? 0;
            document.querySelector(`#difference-balance-bill-10-${uuid}`).textContent = data.denomination_difference.bill_10 ?? 0;
            document.querySelector(`#difference-balance-coin-5-${uuid}`).textContent = data.denomination_difference.coin_5 ?? 0;
            document.querySelector(`#difference-balance-coin-2-${uuid}`).textContent = data.denomination_difference.coin_2 ?? 0;
            document.querySelector(`#difference-balance-coin-1-${uuid}`).textContent = data.denomination_difference.coin_1 ?? 0;
            document.querySelector(`#difference-balance-coin-0-5-${uuid}`).textContent = data.denomination_difference.coin_0_5 ?? 0;
            document.querySelector(`#difference-balance-coin-0-2-${uuid}`).textContent = data.denomination_difference.coin_0_2 ?? 0;
            document.querySelector(`#difference-balance-coin-0-1-${uuid}`).textContent = data.denomination_difference.coin_0_1 ?? 0;
            document.querySelector(`#difference-balance-total-${uuid}`).textContent = parseFloat(data.denomination_difference.total).toFixed(2) ?? 0;
        }
        /*if (document.querySelector(`#show-services-modal-${uuid}`)) {
            const modalContent = document.querySelector(`#show-services-modal-${uuid}`);
            modalContent.innerHTML = '';
            if (data.total_services.length === 0) {
                modalContent.classList.add("py-4");
                modalContent.textContent = "Actualmente no hay registros.";
            } else {
                for (const key in data.total_services) {
                    if (data.total_services.hasOwnProperty(key)) {
                        const serviceData = data.total_services[key];
                        const $contain = document.createElement('div');
                        const $service = document.createElement('div');
                        const $count = document.createElement('div');
                        const $amount = document.createElement('div');
                        const $commission = document.createElement('div');
                        $contain.classList.add("flex", "hover:bg-[#d1d5db44]", "bg-transparent", "transition", "duration-200","py-2","rounded-b-lg");
                        $service.classList.add("flex-1", "text-sm", "text-gray-700", "font-medium", "text-center");
                        $count.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $amount.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $commission.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $service.textContent = serviceData.servicio || key;
                        $count.textContent = serviceData.cantidad || 0;
                        $amount.textContent = serviceData.monto || "0.00";
                        $commission.textContent = serviceData.commission || "0.00";
                        $contain.appendChild($service);
                        $contain.appendChild($count);
                        $contain.appendChild($amount);
                        $contain.appendChild($commission);
                        modalContent.appendChild($contain);
                    }
                }
            }
        }
        if (document.querySelector(`#show-expenses-modal-${uuid}`)) {
            const modalContent = document.querySelector(`#show-services-modal-${uuid}`);
            modalContent.innerHTML = '';
            if (data.total_services.length === 0) {
                modalContent.classList.add("py-4");
                modalContent.textContent = "Actualmente no hay registros.";
            } else {
                for (const key in data.total_services) {
                    if (data.total_services.hasOwnProperty(key)) {
                        const serviceData = data.total_services[key];
                        const $contain = document.createElement('div');
                        const $service = document.createElement('div');
                        const $count = document.createElement('div');
                        const $amount = document.createElement('div');
                        const $commission = document.createElement('div');
                        $contain.classList.add("flex", "hover:bg-[#d1d5db44]", "bg-transparent", "transition", "duration-200","py-2","rounded-b-lg");
                        $service.classList.add("flex-1", "text-sm", "text-gray-700", "font-medium", "text-center");
                        $count.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $amount.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $commission.classList.add("flex-1", "text-sm", "text-gray-700", "text-center");
                        $service.textContent = serviceData.servicio || key;
                        $count.textContent = serviceData.cantidad || 0;
                        $amount.textContent = serviceData.monto || "0.00";
                        $commission.textContent = serviceData.commission || "0.00";
                        $contain.appendChild($service);
                        $contain.appendChild($count);
                        $contain.appendChild($amount);
                        $contain.appendChild($commission);
                        modalContent.appendChild($contain);
                    }
                }
            }
        }*/
        /*
        if (document.querySelector(`#closing-balance-${uuid}`)) {
            document.querySelector(`#closing-balance-${uuid}`).textContent = parseFloat(data.denomination_closing.total).toFixed(2) ?? 0;
        }*/
        openDetailsModal(uuid);
    } catch (error) {
        loader_action_status('hide');
        mdalert({
            title: lang["app_name"],
            type: lang["error_subtitle"],
            msg: lang["error_unknown"]
        });
    }
}
