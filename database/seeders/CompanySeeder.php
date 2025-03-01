<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $name_1 = Activity::where('name', 'Empresas industriales y petroleras')->value('activity_uuid');
        $name_2 = Activity::where('name', 'Empresas gomeras, castañeras, agrícolas, ganaderas y agroindustriales')->value('activity_uuid');
        $name_3 = Activity::where('name', 'Empresas mineras')->value('activity_uuid');
        $name_4 = Activity::where('name', 'Empresas bancarias, de seguros, comerciales, de servicios y otras')->value('activity_uuid');
        Company::create([
            'name' => 'Nuevo Amanecer',
            'nit' => 10014143822,
            'activity_uuid' => $name_4,
            'description' => '',
            'user_id' => 1,
        ]);
    }
}
