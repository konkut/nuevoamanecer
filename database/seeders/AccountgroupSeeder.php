<?php

namespace Database\Seeders;

use App\Models\Accountclass;
use App\Models\Accountgroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountgroupSeeder extends Seeder
{
    public function run(): void
    {
        $name_one = Accountclass::where('name', 'ACTIVO')->value('accountclass_uuid');
        $name_two = Accountclass::where('name', 'PASIVO')->value('accountclass_uuid');
        $name_three = Accountclass::where('name', 'PATRIMONIO')->value('accountclass_uuid');
        $name_four = Accountclass::where('name', 'INGRESOS')->value('accountclass_uuid');
        $name_five = Accountclass::where('name', 'EGRESOS')->value('accountclass_uuid');

        Accountgroup::create(['code' => 1, 'name' => 'ACTIVO CORRIENTE', 'description' => 'Bienes y derechos líquidos a corto plazo.', 'accountclass_uuid' => $name_one, 'user_id' => 1]);
        Accountgroup::create(['code' => 2, 'name' => 'ACTIVO NO CORRIENTE', 'description' => 'Bienes y derechos de largo plazo.', 'accountclass_uuid' => $name_one, 'user_id' => 1]);
        Accountgroup::create(['code' => 1, 'name' => 'PASIVO CORRIENTE', 'description' => 'Obligaciones financieras a corto plazo.', 'accountclass_uuid' => $name_two, 'user_id' => 1]);
        Accountgroup::create(['code' => 2, 'name' => 'PASIVO NO CORRIENTE', 'description' => 'Deudas y obligaciones a largo plazo.', 'accountclass_uuid' => $name_two, 'user_id' => 1]);
        Accountgroup::create(['code' => 1, 'name' => 'PATRIMONIO', 'description' => 'Capital y utilidades retenidas.', 'accountclass_uuid' => $name_three, 'user_id' => 1]);
        Accountgroup::create(['code' => 1, 'name' => 'INGRESOS OPERATIVOS', 'description' => 'Ingresos generados por la actividad principal del negocio.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 2, 'name' => 'INGRESOS FINANCIEROS', 'description' => 'Ganancias provenientes de inversiones o actividades financieras.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 3, 'name' => 'OTROS INGRESOS', 'description' => 'Ingresos extraordinarios no relacionados con la actividad principal.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 4, 'name' => 'AJUSTES Y DIFERENCIAS DE CAMBIO', 'description' => 'Ajustes contables por variaciones en el tipo de cambio.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 1, 'name' => 'COSTOS OPERATIVOS', 'description' => 'Costos directos relacionados con la producción o prestación de servicios.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 2, 'name' => 'GASTOS DE ADMINISTRACIÓN', 'description' => 'Gastos generales para la gestión y operación del negocio.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 3, 'name' => 'GASTOS DE COMERCIALIZACIÓN', 'description' => 'Gastos asociados a la promoción y venta de productos o servicios.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 4, 'name' => 'GASTOS FINANCIEROS', 'description' => 'Intereses y otros costos relacionados con financiamiento.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 5, 'name' => 'OTROS GASTOS', 'description' => 'Gastos no recurrentes o no operativos.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 6, 'name' => 'AJUSTES Y DIFERENCIAS DE CAMBIO', 'description' => 'Pérdidas contables por variaciones en el tipo de cambio.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);



        /*
        $name_one = Accountclass::where('name', 'ACTIVO')->value('accountclass_uuid');
        $name_two = Accountclass::where('name', 'PASIVO')->value('accountclass_uuid');
        $name_three = Accountclass::where('name', 'PATRIMONIO')->value('accountclass_uuid');
        $name_four = Accountclass::where('name', 'INGRESO')->value('accountclass_uuid');
        $name_five = Accountclass::where('name', 'EGRESO')->value('accountclass_uuid');
        $name_six = Accountclass::where('name', 'CUENTAS DE ORDEN DEUDORAS')->value('accountclass_uuid');
        $name_seven = Accountclass::where('name', 'CUENTAS DE ORDEN ACREEDORAS')->value('accountclass_uuid');

        Accountgroup::create(['code' => 101, 'name' => 'ACTIVO CORRIENTE', 'description' => 'Bienes y derechos líquidos a corto plazo.', 'accountclass_uuid' => $name_one, 'user_id' => 1]);
        Accountgroup::create(['code' => 102, 'name' => 'ACTIVO NO CORRIENTE', 'description' => 'Bienes y derechos de largo plazo.', 'accountclass_uuid' => $name_one, 'user_id' => 1]);
        Accountgroup::create(['code' => 201, 'name' => 'PASIVO CORRIENTE', 'description' => 'Obligaciones financieras a corto plazo.', 'accountclass_uuid' => $name_two, 'user_id' => 1]);
        Accountgroup::create(['code' => 202, 'name' => 'PASIVO NO CORRIENTE', 'description' => 'Deudas y obligaciones a largo plazo.', 'accountclass_uuid' => $name_two, 'user_id' => 1]);
        Accountgroup::create(['code' => 301, 'name' => 'PATRIMONIO NETO', 'description' => 'Capital y utilidades retenidas.', 'accountclass_uuid' => $name_three, 'user_id' => 1]);
        Accountgroup::create(['code' => 401, 'name' => 'INGRESOS OPERATIVOS', 'description' => 'Ingresos provenientes de actividades principales.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 402, 'name' => 'INGRESOS NO OPERATIVOS', 'description' => 'Ingresos obtenidos fuera de la actividad principal.', 'accountclass_uuid' => $name_four, 'user_id' => 1]);
        Accountgroup::create(['code' => 501, 'name' => 'COSTOS OPERATIVOS', 'description' => 'Costos directos asociados a la producción.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 502, 'name' => 'GASTOS OPERATIVOS', 'description' => 'Gastos administrativos y de ventas.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 503, 'name' => 'OTRAS CUENTAS DE RESULTADO', 'description' => 'Otras cuentas de resultado', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 504, 'name' => 'CUENTAS TRANSITORIAS', 'description' => 'Registros temporales de movimientos contables.', 'accountclass_uuid' => $name_five, 'user_id' => 1]);
        Accountgroup::create(['code' => 601, 'name' => 'CUENTAS DE ORDEN DEUDORAS COMERCIALES', 'description' => 'Cuentas contingentes que reflejan derechos.', 'accountclass_uuid' => $name_six, 'user_id' => 1]);
        Accountgroup::create(['code' => 701, 'name' => 'CUENTAS DE ORDEN ACREEDORAS COMERCIALES', 'description' => 'Cuentas contingentes que reflejan obligaciones.', 'accountclass_uuid' => $name_seven, 'user_id' => 1]);*/
    }
}
