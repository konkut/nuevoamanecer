<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::create([
            'name' => 'Empresas industriales y petroleras',
            'start_date' => '2025-04-01',
            'end_date' => '2026-03-31',
            'description' => 'Actividades relacionadas con la producción industrial y la explotación de recursos petroleros.',
            'user_id' => 1,
        ]);

        Activity::create([
            'name' => 'Empresas gomeras, castañeras, agrícolas, ganaderas y agroindustriales',
            'start_date' => '2025-07-01',
            'end_date' => '2026-06-30',
            'description' => 'Empresas dedicadas a la producción y comercialización de productos agrícolas, ganaderos y forestales.',
            'user_id' => 1,
        ]);

        Activity::create([
            'name' => 'Empresas mineras',
            'start_date' => '2025-10-01',
            'end_date' => '2026-09-30',
            'description' => 'Exploración, extracción y procesamiento de minerales y recursos naturales.',
            'user_id' => 1,
        ]);

        Activity::create([
            'name' => 'Empresas bancarias, de seguros, comerciales, de servicios y otras',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'description' => 'Actividades financieras, aseguradoras, comerciales y de prestación de servicios diversos.',
            'user_id' => 1,
        ]);

    }
}
