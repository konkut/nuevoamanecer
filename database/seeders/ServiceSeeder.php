<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Servicewithoutprice;
use App\Models\Servicewithprice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_uuid_basic_services = Category::where('name', 'SERVICIOS BÁSICOS')->value('category_uuid');
        $category_uuid_account_services = Category::where('name', 'SERVICIOS CONTABLES')->value('category_uuid');
        $category_uuid_secure_services = Category::where('name', 'SEGUROS')->value('category_uuid');
        $category_uuid_deposit_services = Category::where('name', 'DÉBITO Y CRÉDITO')->value('category_uuid');
        $category_uuid_finance_services = Category::where('name', 'SERVICIOS FINANCIEROS')->value('category_uuid');
        Service::create([
            'name' => 'ASESORAMIENTO CONTABLE Y TRIBUTARIO',
            'description' => 'Consultoría en contabilidad y cumplimiento tributario.',
            'amount' => 30,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ELABORACIÓN DE BALANCE DE APERTURA, GESTIÓN Y CIERRE',
            'description' => 'Preparación y análisis de estados financieros.',
            'amount' => 100,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'LLENADO DE FORMULARIOS FISCALES (IVA-200, IT-400, IUE-500)',
            'description' => 'Asistencia en la correcta declaración de impuestos.',
            'amount' => 200,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'TRÁMITE DE MATRÍCULA DE COMERCIO',
            'description' => 'Registro ante SEPREC para la habilitación de empresas.',
            'amount' => 70,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'TRÁMITE DE LICENCIA DE FUNCIONAMIENTO',
            'description' => 'Gestión de la licencia ante la Alcaldía Municipal.',
            'amount' => 70,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'TRÁMITE DE PLANILLAS DE SUELDOS Y SALARIOS',
            'description' => 'Elaboración y presentación de planillas ante el ROE.',
            'amount' => 70,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'TRÁMITE EN GESTORA Y CNS',
            'description' => 'Registro y actualización de datos en Gestora y CNS.',
            'amount' => 70,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ENVÍO DE LIBROS DE COMPRAS Y VENTAS',
            'description' => 'Presentación de reportes contables ante las autoridades fiscales.',
            'amount' => 40,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ENVÍO DE EE.FF. AL SIAT (FORMULARIO DIGITAL 605)',
            'description' => 'Carga de estados financieros al sistema SIAT.',
            'amount' => 30,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ENVÍO DE LIBROS DE BANCARIZACIÓN',
            'description' => 'Reporte de transacciones bancarias conforme a la normativa.',
            'amount' => 70,
            'category_uuid' => $category_uuid_account_services,
            'user_id' => 1
        ]);

        Service::create(['name' => 'DELAPAZ',
            'description' => 'El pago del servicio de electricidad por la empresa DELAPAZ',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'EPSAS',
            'description' => 'El pago del servicio de agua por la empresa EPSAS',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'YPFB',
            'description' => 'El pago del servicio de gas por la empresa YPFB',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'AXS',
            'description' => 'El pago del servicio de internet por la empresa AXS',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'TIGO',
            'description' => 'El pago del servicio de internet por la empresa TIGO',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'GESTORA',
            'description' => 'El pago del servicio de seguro a largo plazo GESTORA',
            'category_uuid' => $category_uuid_account_services,
            'user_id'=>1
        ]);
        Service::create(['name' => 'B-SISA',
            'description' => 'El pago del servicio de seguro a la empresa ANH',
            'category_uuid' => $category_uuid_secure_services,
            'user_id'=>1
        ]);
        Service::create([
            'name' => 'DEPÓSITO A CUENTA BANCARIA',
            'description' => 'Ingreso de fondos a cuentas bancarias de forma segura y confiable.',
            'category_uuid' => $category_uuid_deposit_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SEGIP',
            'amount' => 17,
            'commission' => 3,
            'description' => 'Pago de trámites de identificación personal y documentos oficiales.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SEGIP DIGITAL',
            'amount' => 20,
            'commission' => 3,
            'description' => 'Pago de trámites de identificación personal y documentos oficiales.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'LICENCIA DUPLICADO',
            'amount' => 160,
            'commission' => 3,
            'description' => 'Pago para emitir o renovar licencias de conducir.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'LICENCIA',
            'amount' => 225,
            'commission' => 3,
            'description' => 'Pago para emitir o renovar licencias de conducir.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ITV',
            'amount' => 30,
            'commission' => 2,
            'description' => 'Pago para la inspección técnica vehicular anual.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'ITV OFICINA',
            'amount' => 30,
            'commission' => 0,
            'description' => 'Pago para la inspección técnica vehicular anual.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'TRANSCRIPCIONES',
            'amount' => 2,
            'description' => 'Servicio de transcripción de textos.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'FOTOCOPIA CARNET',
            'amount' => 0.5,
            'description' =>  'Fotocopia de carnet de identidad.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'FOTOCOPIA',
            'amount' => 0.25,
            'description' =>  'Fotocopia en blanco y negro por hoja.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'IMPRESIÓN A COLOR',
            'amount' => 1,
            'description' =>  'Impresión en alta calidad y color por hoja.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'IMPRESIÓN',
            'amount' => 0.5,
            'description' =>  'Impresión en blanco y negro por hoja.',
            'category_uuid' => $category_uuid_finance_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MOTOCICLETA PARTICULAR',
            'amount' => 200,
            'commission' => 3,
            'description' => 'Cobertura para motocicletas particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT AUTOMÓVIL PARTICULAR',
            'amount' => 90,
            'commission' => 3,
            'description' => 'Cobertura para automóviles particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT JEEP PARTICULAR',
            'amount' => 110,
            'commission' => 3,
            'description' => 'Cobertura para jeeps particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIONETA PARTICULAR',
            'amount' => 140,
            'commission' => 3,
            'description' => 'Cobertura para camionetas particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT VAGONETA PARTICULAR',
            'amount' => 90,
            'commission' => 3,
            'description' => 'Cobertura para vagonetas particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MICROBÚS PARTICULAR',
            'amount' => 460,
            'commission' => 3,
            'description' => 'Cobertura para microbuses particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT COLECTIVO PARTICULAR',
            'amount' => 595,
            'commission' => 3,
            'description' => 'Cobertura para colectivos particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT FLOTA PARTICULAR',
            'amount' => 2630,
            'commission' => 3,
            'description' => 'Cobertura para flotas de más de 39 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT TRACTO CAMIÓN PARTICULAR',
            'amount' => 290,
            'commission' => 3,
            'description' => 'Cobertura para tracto camiones particulares',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PARTICULAR (8 OCUPANTES)',
            'amount' => 140,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 8 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PARTICULAR (11 OCUPANTES)',
            'amount' => 200,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 11 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PARTICULAR (15 OCUPANTES)',
            'amount' => 330,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 15 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PARTICULAR (3 OCUPANTES)',
            'amount' => 330,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 3 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PARTICULAR (18 OCUPANTES)',
            'amount' => 1020,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 18 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PARTICULAR (25 OCUPANTES)',
            'amount' => 1310,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 25 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);

        Service::create([
            'name' => 'SOAT MOTOCICLETA PÚBLICO',
            'amount' => 155,
            'commission' => 3,
            'description' => 'Cobertura para motocicletas públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT AUTOMÓVIL PÚBLICO',
            'amount' => 120,
            'commission' => 3,
            'description' => 'Cobertura para automóviles públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT JEEP PÚBLICO',
            'amount' => 75,
            'commission' => 3,
            'description' => 'Cobertura para jeeps públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIONETA PÚBLICO',
            'amount' => 190,
            'commission' => 3,
            'description' => 'Cobertura para camionetas públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT VAGONETA PÚBLICO',
            'amount' => 125,
            'commission' => 3,
            'description' => 'Cobertura para vagonetas públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MICROBÚS PÚBLICO',
            'amount' => 315,
            'commission' => 3,
            'description' => 'Cobertura para microbuses públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT COLECTIVO PÚBLICO',
            'amount' => 335,
            'commission' => 3,
            'description' => 'Cobertura para colectivos públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT FLOTA PÚBLICO',
            'amount' => 3700,
            'commission' => 3,
            'description' => 'Cobertura para flotas de más de 39 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT TRACTO CAMIÓN PÚBLICO',
            'amount' => 185,
            'commission' => 3,
            'description' => 'Cobertura para tracto camiones públicas',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PÚBLICO (8 OCUPANTES)',
            'amount' => 125,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 8 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PÚBLICO (11 OCUPANTES)',
            'amount' => 190,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 11 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT MINIBÚS PÚBLICO (15 OCUPANTES)',
            'amount' => 245,
            'commission' => 3,
            'description' => 'Cobertura para minibuses de 15 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PÚBLICO (3 OCUPANTES)',
            'amount' => 195,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 3 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PÚBLICO (18 OCUPANTES)',
            'amount' => 975,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 18 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
        Service::create([
            'name' => 'SOAT CAMIÓN PÚBLICO (25 OCUPANTES)',
            'amount' => 1260,
            'commission' => 3,
            'description' => 'Cobertura para camiones de 25 ocupantes',
            'category_uuid' => $category_uuid_secure_services,
            'user_id' => 1
        ]);
    }
}
