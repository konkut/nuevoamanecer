function searchPaymentwithoutprice(th, placeholder) {
    if (th.querySelector("input")) return;
    const field = th.innerHTML;
    const container = document.createElement("div");
    container.className = "flex justify-center items-center w-full";
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Buscar " + placeholder;
    input.className = "border-0 focus:outline-none rounded-full px-2 py-1 w-24 text-xs text-gray-700";
    input.style.textAlign = "center";
    th.innerHTML = "";
    container.appendChild(input);
    th.appendChild(container);
    input.focus();

    const form = document.getElementById(`search-form`);
    const url = form.action;
    const csrfToken = document.querySelector('input[name="_token"]').value;

    input.addEventListener("keyup", function () {
        const query = input.value;
        fetch(`${url}?field=${placeholder}&query=${encodeURIComponent(query)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,

            },
        }).then(response => {
                if (!response.ok) {
                    throw new Error('Error en la búsqueda');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                updateTable(data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('No se pudo realizar la búsqueda.');
            });
    });
    input.addEventListener("blur", function () {
        th.innerHTML = field;
    });
}
function updateTable(data) {
    const tableBody = document.querySelector('tbody');
    tableBody.innerHTML = '';
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
           <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                    @if (!empty($item->services))
                        {{ implode(', ', $item->services->toArray()) }}
                    @else
                        N/A
                    @endif</td>
                <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                    @if (!empty($item->total))
                        {{ ($item->total) }}
                    @else
                        N/A
                    @endif</td>
                </td>
                <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                    @if (!empty($item->methods))
                        {{ implode(', ', $item->methods->toArray()) }}
                    @else
                        N/A
                    @endif
                </td>
                <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->created_at->diffForHumans() }}</td>
                @can('paymentwithoutpricesuser.showuser')
                    <td class="border-t border-b border-[#d1d5db] px-2 py-1 registrado-por">{{ $item->user->name }}</td>
                @endcan
                <td class="border-t border-b border-[#d1d5db] px-2 py-1">
                    <div class="flex justify-center space-x-1">
                        <form id="details-form-{{$item->paymentwithoutprice_uuid}}"
                              action="{{ route('paymentwithoutpricesdetail.showdetail', $item->paymentwithoutprice_uuid) }}"
                              method="POST" style="display: inline;">
                            @csrf
                            <button type="button"
                                    onclick="fetchDetails('{{$item->paymentwithoutprice_uuid}}')"
                                    class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                <i class="bi bi-eye"></i>
                            </button>
                        </form>
                        <a href="{{ route('paymentwithoutprices.edit',$item->paymentwithoutprice_uuid) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button"
                                class="bg-red-500 text-white px-2 py-1 rounded text-xs"
                                onclick="openModal('{{ $item->paymentwithoutprice_uuid }}', '{{ implode(', ', $item->services->toArray()) }}')">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </td>
        `;
        tableBody.appendChild(row);
    });
}
