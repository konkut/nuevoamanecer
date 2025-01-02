@if($data)
    <div class="bg-yellow-50 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-4 text-slate-700 rounded-lg shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
                <x-form-panel :title="'APERTURA'" :data="$data['opening']" :incomesdigital="false"
                              :expensesdigital="false"></x-form-panel>
                <x-form-panel :title="'INGRESOS'" :data="$data['incomes']"
                              :incomesdigital="$session_incomes_digital"
                              :expensesdigital="false"></x-form-panel>
                <x-form-panel :title="'EGRESOS'" :data="$data['expenses']" :incomesdigital="false"
                              :expensesdigital="$session_expenses_digital"></x-form-panel>
                <x-form-panel :title="'FÍSICO'" :data="$data['physical']" :incomesdigital="false"
                              :expensesdigital="false"></x-form-panel>
                <x-form-panel :title="'DIGITAL'" :data="$data['closing']" :incomesdigital="false"
                              :expensesdigital="false"></x-form-panel>
                <x-form-panel :title="'DIFERENCIA'" :data="$data['difference']" :incomesdigital="false"
                              :expensesdigital="false"></x-form-panel>
            </div>
            <p class="text-xl font-semibold p-4 my-4 text-center ">Movimientos Realizados</p>
            <div class="flex gap-6 font-extrabold text-sm text-gray-700 text-center py-4">
                <p class="flex-1">NOMBRE</p>
                <p class="hidden sm:flex flex-1 justify-center">PRECIO</p>
                <p class="hidden sm:flex flex-1 justify-center">COMISIÓN</p>
                <p class="hidden sm:flex flex-1 justify-center">CANTIDAD</p>
                <p class="flex-1">TOTAL</p>
            </div>
            <x-form-detail-panel :detail="$session_payment_without_prices_detail"></x-form-detail-panel>
            <x-form-detail-panel :detail="$session_payment_with_prices_detail"></x-form-detail-panel>
            <x-form-detail-panel :detail="$session_sales_detail"></x-form-detail-panel>
            <x-form-detail-panel :detail="$session_expenses_detail"></x-form-detail-panel>
        </div>
    </div>
@endif
