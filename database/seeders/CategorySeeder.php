<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
      Category::create(['name' => 'SERVICIOS FINANCIEROS', 'description' => 'Pagos de servicios financieros, transferencias, y manejo de cuentas.']);
      Category::create(['name' => 'SERVICIOS BÁSICOS', 'description' => 'Pagos de servicios básicos como agua, luz, gas, internet, y otros esenciales.']);
      Category::create(['name' => 'SEGUROS', 'description' => 'Contratación y pago de seguros diversos, incluyendo salud, vida y propiedad.']);
      Category::create(['name' => 'IMPUESTOS', 'description' => 'Gestión y pago de impuestos locales, nacionales, y municipales.']);
      Category::create(['name' => 'TRANSFERENCIAS', 'description' => 'Envío de dinero entre cuentas o hacia terceros, incluyendo servicios interbancarios.']);
      Category::create(['name' => 'RETIROS', 'description' => 'Extracción de dinero desde cuentas bancarias u otros sistemas financieros.']);
      Category::create(['name' => 'SERVICIOS CONTABLES', 'description' => 'Servicios de asesoramiento contable y tributario para empresas y personas.']);
      Category::create(['name' => 'VENTA DE MATERIALES', 'description' => 'Venta de artículos como bolígrafos, formularios y otros materiales de oficina.']);
      Category::create(['name' => 'FOTOCOPIAS E IMPRESIONES', 'description' => 'Servicios de fotocopias, impresiones en diversos formatos y transcripciones de documentos.']);
      Category::create(['name' => 'PUBLICIDAD Y MARKETING', 'description' => 'Creación y distribución de material publicitario para promover servicios.']);
      Category::create(['name' => 'DESAYUNOS Y COMIDAS', 'description' => 'Gastos relacionados con la provisión de alimentos como desayunos, almuerzos y refrigerios.']);
      Category::create(['name' => 'GASTOS ADMINISTRATIVOS', 'description' => 'Gastos generales de la empresa, como alquileres, mantenimiento, y servicios públicos.']);
      Category::create(['name' => 'GASTOS OPERATIVOS', 'description' => 'Gastos relacionados con la operación del negocio, como transporte o eventos corporativos.']);
    //Category::factory()->count(100)->create();
  }
}
