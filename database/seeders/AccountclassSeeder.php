<?php

namespace Database\Seeders;

use App\Models\Accountclass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountclassSeeder extends Seeder
{

    public function run(): void
    {
        Accountclass::create(['code' => 1, 'name' => 'ACTIVO', 'description' => 'Recursos y bienes que posee la empresa.', 'user_id' => 1]);
        Accountclass::create(['code' => 2, 'name' => 'PASIVO', 'description' => 'Obligaciones y deudas con terceros.', 'user_id' => 1]);
        Accountclass::create(['code' => 3, 'name' => 'PATRIMONIO', 'description' => 'Aportes y utilidades de los propietarios.', 'user_id' => 1]);
        Accountclass::create(['code' => 4, 'name' => 'INGRESOS', 'description' => 'Ganancias generadas por la empresa.', 'user_id' => 1]);
        Accountclass::create(['code' => 5, 'name' => 'EGRESOS', 'description' => 'Gastos y costos operativos.', 'user_id' => 1]);

        /*Accountclass::create(['code' => 1, 'name' => 'ACTIVO', 'description' => 'Recursos y bienes que posee la empresa.', 'user_id' => 1]);
        Accountclass::create(['code' => 2, 'name' => 'PASIVO', 'description' => 'Obligaciones y deudas con terceros.', 'user_id' => 1]);
        Accountclass::create(['code' => 3, 'name' => 'PATRIMONIO', 'description' => 'Aportes y utilidades de los propietarios.', 'user_id' => 1]);
        Accountclass::create(['code' => 4, 'name' => 'INGRESO', 'description' => 'Ganancias generadas por la empresa.', 'user_id' => 1]);
        Accountclass::create(['code' => 5, 'name' => 'EGRESO', 'description' => 'Gastos y costos operativos.', 'user_id' => 1]);
        Accountclass::create(['code' => 6, 'name' => 'CUENTAS DE ORDEN DEUDORAS', 'description' => 'Registros de derechos contingentes.', 'user_id' => 1]);
        Accountclass::create(['code' => 7, 'name' => 'CUENTAS DE ORDEN ACREEDORAS', 'description' => 'Registros de obligaciones contingentes.', 'user_id' => 1]);*/
    }
}
