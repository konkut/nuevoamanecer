<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Product;
use App\Models\Servicewithprice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicewithpriceSeeder extends Seeder
{
    public function run(): void
    {
        $category_uuid = Category::where('name', 'SERVICIOS FINANCIEROS')->value('category_uuid');
        Servicewithprice::create([
            'name' => 'SEGIP',
            'amount' => 17,
            'commission' => 3,
            'description' => 'Pago de trámites de identificación personal y documentos oficiales.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'SEGIP DIGITAL',
            'amount' => 20,
            'commission' => 3,
            'description' => 'Pago de trámites de identificación personal y documentos oficiales.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'LICENCIA DUPLICADO',
            'amount' => 160,
            'commission' => 3,
            'description' => 'Pago para emitir o renovar licencias de conducir.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'LICENCIA',
            'amount' => 225,
            'commission' => 3,
            'description' => 'Pago para emitir o renovar licencias de conducir.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'ITV',
            'amount' => 30,
            'commission' => 2,
            'description' => 'Pago para la inspección técnica vehicular anual.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'ITV OFICINA',
            'amount' => 30,
            'commission' => 0,
            'description' => 'Pago para la inspección técnica vehicular anual.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'TRANSCRIPCIONES',
            'amount' => 2,
            'commission' => 0,
            'description' => 'Servicio de transcripción de textos.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'FOTOCOPIA CARNET',
            'amount' => 0.5,
            'commission' => 0,
            'description' =>  'Fotocopia de carnet de identidad.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'FOTOCOPIA',
            'amount' => 0.25,
            'commission' => 0,
            'description' =>  'Fotocopia en blanco y negro por hoja.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'IMPRESIÓN A COLOR',
            'amount' => 1,
            'commission' => 0,
            'description' =>  'Impresión en alta calidad y color por hoja.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Servicewithprice::create([
            'name' => 'IMPRESIÓN',
            'amount' => 0.5,
            'commission' => 0,
            'description' =>  'Impresión en blanco y negro por hoja.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
    }
}
