@if($data)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <x-form-panel :title="'APERTURA'" :data="$data['opening']"></x-form-panel>
        <x-form-panel :title="'INGRESOS'" :data="$data['incomes']"></x-form-panel>
        <x-form-panel :title="'EGRESOS'" :data="$data['expenses']"></x-form-panel>
        <x-form-panel :title="'CIERRE'" :data="$data['closing']"></x-form-panel>
        {{--
        <x-form-panel :title="'FÍSICO'" :data="$data['physical']"></x-form-panel>
        <x-form-panel :title="'DIFERENCIA'" :data="$data['difference']"></x-form-panel>
        --}}
    </div>
    <div class="bg-white shadow-xl rounded-lg mt-8">
        <p class="text-xl font-semibold p-4 my-4 text-center ">Movimientos Realizados</p>
        <div class="flex gap-6 font-extrabold text-sm text-gray-700 text-center py-4">
            <p class="flex-1">NOMBRE</p>
            <p class="hidden sm:flex flex-1 justify-center">PRECIO</p>
            <p class="hidden sm:flex flex-1 justify-center">COMISIÓN</p>
            <p class="hidden sm:flex flex-1 justify-center">CANTIDAD</p>
            <p class="flex-1">TOTAL</p>
        </div>
        <x-form-detail-panel :detail="$session_incomes_detail"></x-form-detail-panel>
        <x-form-detail-panel :detail="$session_sales_detail"></x-form-detail-panel>
        <x-form-detail-panel :detail="$session_expenses_detail"></x-form-detail-panel>
    </div>
@endif
