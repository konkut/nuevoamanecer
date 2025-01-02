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
        $category_uuid_basic_services = Category::where('name', 'SERVICIOS BÁSICOS')->value('category_uuid');
        $category_uuid_account_services = Category::where('name', 'SERVICIOS CONTABLES')->value('category_uuid');
        $category_uuid_secure_services = Category::where('name', 'SEGUROS')->value('category_uuid');
        Servicewithoutprice::create(['name' => 'DELAPAZ',
            'description' => 'El pago del servicio de electricidad por la empresa DELAPAZ',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'EPSAS',
            'description' => 'El pago del servicio de agua por la empresa EPSAS',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'YPFB',
            'description' => 'El pago del servicio de gas por la empresa YPFB',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'AXS',
            'description' => 'El pago del servicio de internet por la empresa AXS',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'TIGO',
            'description' => 'El pago del servicio de internet por la empresa TIGO',
            'category_uuid' => $category_uuid_basic_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'GESTORA',
            'description' => 'El pago del servicio de seguro a largo plazo GESTORA',
            'category_uuid' => $category_uuid_account_services,
            'user_id'=>1
        ]);
        Servicewithoutprice::create(['name' => 'B-SISA',
            'description' => 'El pago del servicio de seguro a la empresa ANH',
            'category_uuid' => $category_uuid_secure_services,
            'user_id'=>1
        ]);

    }
}
