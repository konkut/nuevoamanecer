<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //User::factory(500)->create();

        User::create([
            'name' => 'Pedro Luis',
            'email' => 'luis@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Ibeth Pamela',
            'email' => 'ibeth@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Tatiana',
            'email' => 'tatiana@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Jesus',
            'email' => 'jesus@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Caja');

        User::create([
            'name' => 'Cameron',
            'email' => 'cameron@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Caja');

        User::create([
            'name' => 'Jhovana',
            'email' => 'jhovana@gmail.com',
            'password' => bcrypt('12345678'),
            'password_changed_at' => now(),
        ])->assignRole('Caja');


    }
}
