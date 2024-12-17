function fetchDetails(uuid) {
    const form = document.getElementById(`details-form-${uuid}`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petición');
            }
            return response.json();
        })
        .then(data => {
            let contain_bill_coin = document.querySelector(`#modal-show-${uuid}`);
            contain_bill_coin.innerHTML = "";
            let content = "";
             content = `
             <table class="min-w-full border-collapse border-[#f3f4f6] text-center text-sm">
                <thead >
                    <tr style='background: #f3f4f6;'>
                        <th class="border-t border-b border-[#f3f4f6] px-2 py-1" colspan="3">Billetaje</th>
                    </tr>
                </thead>
                <tbody>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">200</td>
                    <td class="border-b py-1 text-start w-1/2">${data.bill_200}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">100</td>
                    <td class="border-b py-1 text-start w-1/2">${data.bill_100}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">50</td>
                    <td class="border-b py-1 text-start w-1/2">${data.bill_50}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">20</td>
                    <td class="border-b py-1 text-start w-1/2">${data.bill_20}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">10</td>
                    <td class="border-b py-1 text-start w-1/2">${data.bill_10}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">5</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_5}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">2</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_2}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">1</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_1}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">0.5</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_0_5}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">0.2</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_0_2}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">0.1</td>
                    <td class="border-b py-1 text-start w-1/2">${data.coin_0_1}</td>
                </tr>
                <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                    <td class="border-b py-1 text-end w-1/3">Bs</td>
                    <td class="border-b py-1 text-start w-1/3">Total</td>
                    <td class="border-b py-1 text-start w-1/2">${data.total}</td>
                </tr>
                </tbody>
            </table>`;
            contain_bill_coin.innerHTML = content;
            let contain_bill_coin_closing = document.querySelector(`#modal-closing-${uuid}`);
            if (contain_bill_coin_closing) {
                contain_bill_coin_closing.innerHTML = "";
                let closing = "";
                closing = `
                 <table class="min-w-full border-collapse border-[#f3f4f6] text-center text-sm">
                    <thead >
                        <tr style='background: #f3f4f6;'>
                            <th class="border-t border-b border-[#f3f4f6] px-2 py-1" colspan="3">Monto de cierre</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">200</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_bill_200}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">100</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_bill_100}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">50</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_bill_50}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">20</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_bill_20}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">10</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_bill_10}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">5</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_5}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">2</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_2}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">1</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_1}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">0.5</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_0_5}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">0.2</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_0_2}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">0.1</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_coin_0_1}</td>
                    </tr>
                    <tr class="hover:bg-[#d1d5db44] transition duration-200 w-full">
                        <td class="border-b py-1 text-end w-1/3">Bs</td>
                        <td class="border-b py-1 text-start w-1/3">Total</td>
                        <td class="border-b py-1 text-start w-1/2">${data.total_total}</td>
                    </tr>
                    </tbody>
                </table>`;
                contain_bill_coin_closing.innerHTML = closing;

            }

            openDetailsModal(uuid);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
