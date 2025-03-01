<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $name_1 = Company::where('name', 'Nuevo Amanecer')->value('company_uuid');
        Project::create([
            'name' => 'Proyecto 1 (Nuevo Amanecer)',
            'start_date' => '2025-04-01',
            'end_date' => '2026-03-31',
            'budget' => 2000,
            'company_uuid' => $name_1,
            'description' => '',
            'user_id' => 1,
        ]);
    }
}
