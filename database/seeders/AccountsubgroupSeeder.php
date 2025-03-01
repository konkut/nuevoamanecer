<?php

namespace Database\Seeders;

use App\Models\Accountgroup;
use App\Models\Accountsubgroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountsubgroupSeeder extends Seeder
{

    public function run(): void
    {
        $name_one = Accountgroup::where('name', 'ACTIVO CORRIENTE')->value('accountgroup_uuid');
        $name_two = Accountgroup::where('name', 'ACTIVO NO CORRIENTE')->value('accountgroup_uuid');
        $name_three = Accountgroup::where('name', 'PASIVO CORRIENTE')->value('accountgroup_uuid');
        $name_four = Accountgroup::where('name', 'PASIVO NO CORRIENTE')->value('accountgroup_uuid');
        $name_five = Accountgroup::where('name', 'PATRIMONIO NETO')->value('accountgroup_uuid');
        $name_six = Accountgroup::where('name', 'INGRESOS OPERATIVOS')->value('accountgroup_uuid');
        $name_seven = Accountgroup::where('name', 'INGRESOS NO OPERATIVOS')->value('accountgroup_uuid');
        $name_eight = Accountgroup::where('name', 'COSTOS OPERATIVOS')->value('accountgroup_uuid');
        $name_nine = Accountgroup::where('name', 'GASTOS OPERATIVOS')->value('accountgroup_uuid');
        $name_ten = Accountgroup::where('name', 'OTRAS CUENTAS DE RESULTADO')->value('accountgroup_uuid');
        $name_eleven = Accountgroup::where('name', 'CUENTAS TRANSITORIAS')->value('accountgroup_uuid');
        $name_twelve = Accountgroup::where('name', 'CUENTAS DE ORDEN DEUDORAS COMERCIALES')->value('accountgroup_uuid');
        $name_thirteen = Accountgroup::where('name', 'CUENTAS DE ORDEN ACREEDORAS COMERCIALES')->value('accountgroup_uuid');

        Accountsubgroup::create(['code' => 10101, 'name' => 'DISPONIBILIDADES', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10102, 'name' => 'EXIGIBLE', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10103, 'name' => 'ACTIVO REALIZABLE O BIEN', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10104, 'name' => 'PAGOS ANTICIPADOS', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10105, 'name' => 'INVERSIONES TEMPORARIAS', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10106, 'name' => 'OTROS ACTIVOS CORRIENTES', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10201, 'name' => 'ACTIVO FIJO - BIENES DE USO, PROPIEDAD PLANTA', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10202, 'name' => 'ACTIVOS INTANGIBLES', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10203, 'name' => 'CARGOS DIFERIDOS', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10204, 'name' => 'INVERSIONES A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20101, 'name' => 'OBLIGACIONES COMERCIALES', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20102, 'name' => 'OBLIGACIONES TRIBUTARIAS', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20103, 'name' => 'OBLIGACIONES LABORALES', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20104, 'name' => 'OTRAS CUENTAS POR PAGAR', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20105, 'name' => 'INGRESOS ANTICIPADOS O DIFERIDOS', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 20201, 'name' => 'OBLIGACIONES A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_four, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 30101, 'name' => 'CAPITAL', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 30102, 'name' => 'RESERVAS', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 30103, 'name' => 'RESULTADOS ACUMULADOS', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 40101, 'name' => 'INGRESOS ORDINARIOS', 'description' => '', 'accountgroup_uuid' => $name_six, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 40102, 'name' => 'INGRESOS NO ORDINARIOS', 'description' => '', 'accountgroup_uuid' => $name_six, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 40201, 'name' => 'INGRESO NO OPERATIVO', 'description' => '', 'accountgroup_uuid' => $name_seven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50101, 'name' => 'COSTO DE BIENES Y SERVICIOS VENDIDOS', 'description' => '', 'accountgroup_uuid' => $name_eight, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50201, 'name' => 'GASTOS ADMINISTRATIVOS', 'description' => '', 'accountgroup_uuid' => $name_nine, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50202, 'name' => 'GASTOS DE COMERCIALIZACION', 'description' => '', 'accountgroup_uuid' => $name_nine, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50203, 'name' => 'GASTOS FINANCIEROS', 'description' => '', 'accountgroup_uuid' => $name_nine, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50301, 'name' => 'OTROS GASTOS', 'description' => '', 'accountgroup_uuid' => $name_ten, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 50401, 'name' => 'CUENTAS TRANSITORIAS', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 60101, 'name' => 'CUENTAS DE ORDEN DEUDORAS COMERCIALES', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 70101, 'name' => 'CUENTAS DE ORDEN ACREEDORAS COMERCIALES', 'description' => '', 'accountgroup_uuid' => $name_thirteen, 'user_id' => 1]);
    }
}
