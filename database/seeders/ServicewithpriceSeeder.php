<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Servicewithprice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicewithpriceSeeder extends Seeder
{
    public function run(): void
    {
        $category_uuid = Category::where('name', 'SERVICIOS FINANCIEROS')->value('category_uuid');
        Servicewithprice::create([
            'name' => 'PAGO SEGIP', 
            'amount' => '17', 
            'commission' => '3', 
            'description' => 'Pago de trámites de identificación personal y documentos oficiales.', 
            'category_uuid' => $category_uuid, 
            'user_id' => 1
        ]);
        
        Servicewithprice::create([
            'name' => 'PAGO ITV',
            'amount' => '70', 
            'commission' => '5',  
            'description' => 'Pago para la inspección técnica vehicular anual.', 
            'category_uuid' => $category_uuid, 
            'user_id' => 1
        ]);
        
        Servicewithprice::create([
            'name' => 'PAGO LICENCIA DE CONDUCIR', 
            'amount' => '64', 
            'commission' => '3', 
            'description' => 'Pago para emitir o renovar licencias de conducir.', 
            'category_uuid' => $category_uuid, 
            'user_id' => 1
        ]);
    }
}
