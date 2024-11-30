<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Servicewithoutprice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicewithoutpriceSeeder extends Seeder
{
    
    public function run(): void
    {
        $category_uuid = Category::where('name', 'SERVICIOS BÁSICOS')->value('category_uuid');
        Servicewithoutprice::create(['name' => 'PAGO DELAPAZ', 'description' => 'El pago del servicio de electricidad por la empresa DELAPAZ','category_uuid' => $category_uuid, 'user_id'=>1]);
        Servicewithoutprice::create(['name' => 'PAGO EPSAS', 'description' => 'El pago del servicio de agua por la empresa EPSAS','category_uuid' => $category_uuid, 'user_id'=>1]);
        Servicewithoutprice::create(['name' => 'PAGO YPFB', 'description' => 'El pago del servicio de gas por la empresa YPFB','category_uuid' => $category_uuid, 'user_id'=>1]);
    }
}
