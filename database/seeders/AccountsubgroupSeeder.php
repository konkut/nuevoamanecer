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
        $name_five = Accountgroup::where('name', 'PATRIMONIO')->value('accountgroup_uuid');
        $name_six = Accountgroup::where('name', 'INGRESOS OPERATIVOS')->value('accountgroup_uuid');
        $name_seven = Accountgroup::where('name', 'INGRESOS FINANCIEROS')->value('accountgroup_uuid');
        $name_eight = Accountgroup::where('name', 'OTROS INGRESOS')->value('accountgroup_uuid');
        $name_nine = Accountgroup::join('accountclasses','accountclasses.accountclass_uuid','=','accountgroups.accountclass_uuid')
            ->where('accountclasses.name','INGRESOS')
            ->where('accountgroups.name', 'AJUSTES Y DIFERENCIAS DE CAMBIO')
            ->value('accountgroups.accountgroup_uuid');
        $name_ten = Accountgroup::where('name', 'COSTOS OPERATIVOS')->value('accountgroup_uuid');
        $name_eleven = Accountgroup::where('name', 'GASTOS DE ADMINISTRACIÓN')->value('accountgroup_uuid');
        $name_twelve = Accountgroup::where('name', 'GASTOS DE COMERCIALIZACIÓN')->value('accountgroup_uuid');
        $name_thirteen = Accountgroup::where('name', 'GASTOS FINANCIEROS')->value('accountgroup_uuid');
        $name_fourteen = Accountgroup::where('name', 'OTROS GASTOS')->value('accountgroup_uuid');
        $name_fifteen = Accountgroup::join('accountclasses','accountclasses.accountclass_uuid','=','accountgroups.accountclass_uuid')
            ->where('accountclasses.name','EGRESOS')
            ->where('accountgroups.name', 'AJUSTES Y DIFERENCIAS DE CAMBIO')
            ->value('accountgroups.accountgroup_uuid');


        Accountsubgroup::create(['code' => 1, 'name' => 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'EXIGIBLE DE CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'REALIZABLE DE CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'ACTIVOS TRANSITORIOS', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 5, 'name' => 'ACTIVOS DIFERIDOS A CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 6, 'name' => 'CUENTAS FISCALES', 'description' => '', 'accountgroup_uuid' => $name_one, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'EXIGIBLE A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'PROPIEDAD DE INVERSIÓN', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'PROPIEDADES, PLANTA y EQUIPO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'DEPRECIACIÓN ACUMULADA', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 5, 'name' => 'ACTIVOS BIOLÓGICOS', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 6, 'name' => 'INVERSIONES DE LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 7, 'name' => 'ACTIVOS TRANSITORIOS', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 8, 'name' => 'OTROS ACTIVOS FINANCIEROS NO CORRIENTES', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 9, 'name' => 'ACTIVO DIFERIDO A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 10, 'name' => 'ACTIVOS INTANGIBLES', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 11, 'name' => 'OTROS ACTIVOS DE LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_two, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'OBLIGACIONES FINANCIERAS A CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'CUENTAS POR PAGAR A CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'OBLIGACIONES SOCIALES', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'OBLIGACIONES FISCALES', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 5, 'name' => 'PROVISIONES', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 6, 'name' => 'PASIVO DIFERIDO A CORTO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_three, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'OBLIGACIONES FINANCIERAS A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_four, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'CUENTAS POR PAGAR A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_four, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'PREVISIONES', 'description' => '', 'accountgroup_uuid' => $name_four, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'PASIVO DIFERIDO A LARGO PLAZO', 'description' => '', 'accountgroup_uuid' => $name_four, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'CAPITAL', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'RESERVAS', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'RESULTADOS ACUMULADOS', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'RESULTADOS DEL EJERCICIO', 'description' => '', 'accountgroup_uuid' => $name_five, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'INGRESOS POR VENTAS', 'description' => '', 'accountgroup_uuid' => $name_six, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'INGRESOS FINANCIEROS', 'description' => '', 'accountgroup_uuid' => $name_seven, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'OTROS INGRESOS', 'description' => '', 'accountgroup_uuid' => $name_eight, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'AJUSTES Y DIFERENCIAS DE CAMBIO', 'description' => '', 'accountgroup_uuid' => $name_nine, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'COSTO DE VENTAS', 'description' => '', 'accountgroup_uuid' => $name_ten, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'COSTO DE PRODUCCIÓN', 'description' => '', 'accountgroup_uuid' => $name_ten, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'DEVOLUCIONES, DESCUENTOS Y REBAJAS CONCEDIDAS', 'description' => '', 'accountgroup_uuid' => $name_ten, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'MERMAS Y FALLAS EN EXISTENCIAS', 'description' => '', 'accountgroup_uuid' => $name_ten, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'REMUNERACIONES', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'GASTOS GENERALES DE OFICINA', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'SERVICIOS ESPECIALIZADOS', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'DEPRECIACIONES BIENES DE USO Y AMORTIZACIONES', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 5, 'name' => 'IMPUESTOS, TASAS Y PATENTES', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 6, 'name' => 'OTROS GASTOS DE ADMINISTRACIÓN', 'description' => '', 'accountgroup_uuid' => $name_eleven, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'REMUNERACIONES', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 2, 'name' => 'GASTOS OPERACIONALES', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 3, 'name' => 'PUBLICIDAD, MARKETING Y PROPAGANDA', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 4, 'name' => 'SERVICIOS ESPECIALIZADOS', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 5, 'name' => 'DEPRECIACIONES BIENES DE USO Y AMORTIZACIONES', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);
        Accountsubgroup::create(['code' => 6, 'name' => 'OTROS GASTOS DE COMERCIALIZACIÓN', 'description' => '', 'accountgroup_uuid' => $name_twelve, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'GASTOS BANCARIOS', 'description' => '', 'accountgroup_uuid' => $name_thirteen, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'OTROS GASTOS', 'description' => '', 'accountgroup_uuid' => $name_fourteen, 'user_id' => 1]);

        Accountsubgroup::create(['code' => 1, 'name' => 'AJUSTES Y DIFERENCIAS DE CAMBIO', 'description' => '', 'accountgroup_uuid' => $name_fifteen, 'user_id' => 1]);



        /*
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
        Accountsubgroup::create(['code' => 70101, 'name' => 'CUENTAS DE ORDEN ACREEDORAS COMERCIALES', 'description' => '', 'accountgroup_uuid' => $name_thirteen, 'user_id' => 1]);*/
    }
}
