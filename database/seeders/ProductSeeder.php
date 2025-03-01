<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Servicewithoutprice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category_uuid = Category::where('name', 'VENTA DE MATERIALES')->value('category_uuid');
        Product::create([
            'name' => 'FORMULARIO SEGIP',
            'price' => 1,
            'stock' => 100,
            'description' => 'Formulario oficial para trámites SEGIP.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FORMULARIO ITV',
            'price' => 5,
            'stock' => 100,
            'description' => 'Formulario para Inspección Técnica Vehicular.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'CERTIFICADOS',
            'price' => 2,
            'stock' => 100,
            'description' => 'Certificados en papel bond de alta calidad.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'BOLIGRAFO',
            'price' => 1,
            'stock' => 100,
            'description' => 'Bolígrafo azul de tinta duradera.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FOLDER AMARILLO OFICIO',
            'price' => 3,
            'stock' => 100,
            'description' => 'Folder amarillo tamaño oficio resistente.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FOLDER AMARILLO CARTA',
            'price' => 3,
            'stock' => 100,
            'description' => 'Folder amarillo tamaño carta práctico.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FOLDER TRANSPARENTE PEQUEÑO',
            'price' => 2,
            'stock' => 100,
            'description' => 'Folder transparente ideal para documentos pequeños.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FUNDA',
            'price' => 0.5,
            'stock' => 100,
            'description' => 'Funda plástica para proteger documentos.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'SOBRE MANILA OFICIO',
            'price' => 2,
            'stock' => 100,
            'description' => 'Sobre Manila tamaño oficio para documentos.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'SOBRE MANILA CARTA',
            'price' => 2,
            'stock' => 100,
            'description' => 'Sobre Manila tamaño carta práctico.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'PORTACARNET',
            'price' => 1,
            'stock' => 100,
            'description' => 'Portacarnet plástico práctico y seguro.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'FLIP',
            'price' => 2,
            'stock' => 100,
            'description' => 'Flip chart para presentaciones.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'TARJETAS ENTEL',
            'price' => 10,
            'stock' => 100,
            'description' => 'Tarjetas de recarga Entel por Bs. 10.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'TARJETAS VIVA',
            'price' => 10,
            'stock' => 100,
            'description' => 'Tarjetas de recarga Viva por Bs. 10.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'TARJETAS TIGO',
            'price' => 10,
            'stock' => 100,
            'description' => 'Tarjetas de recarga Tigo por Bs. 10.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'PEINE',
            'price' => 1,
            'stock' => 100,
            'description' => 'Peine resistente de uso personal.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'RADEX EN CINTA',
            'price' => 5,
            'stock' => 100,
            'description' => 'Radex en cinta adhesiva de alta calidad.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'ETIQUETADORES',
            'price' => 5,
            'stock' => 100,
            'description' => 'Etiquetadores para organización de documentos.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'LIGAS',
            'price' => 1,
            'stock' => 100,
            'description' => 'Ligas elásticas para múltiples usos.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
        Product::create([
            'name' => 'ORQUILLAS',
            'price' => 1,
            'stock' => 100,
            'description' => 'Orquillas metálicas para organizar papeles.',
            'category_uuid' => $category_uuid,
            'user_id' => 1
        ]);
    }
}
