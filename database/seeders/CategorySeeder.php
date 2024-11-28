<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
    Category::create(['name' => 'SERVICIOS BÁSICOS', 'description' => 'Pagos de servicios básicos como agua, luz, gas, y otros esenciales.']);
    Category::create(['name' => 'SEGUROS', 'description' => 'Contratación y pago de seguros diversos, incluyendo salud, vida y propiedad.']);
    Category::create(['name' => 'IMPUESTOS', 'description' => 'Gestión y pago de impuestos locales y nacionales.']);
    Category::create(['name' => 'TRANSFERENCIAS', 'description' => 'Envío de dinero entre cuentas o hacia terceros.']);
    Category::create(['name' => 'RETIROS', 'description' => 'Extracción de dinero desde cuentas bancarias u otros sistemas financieros.']);
    Category::create(['name' => 'SERVICIOS CONTABLES', 'description' => 'Servicios de asesoramiento contable y tributaria para empresas y personas.']);

  }
}
