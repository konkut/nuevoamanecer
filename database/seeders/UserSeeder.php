<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    //User::factory(3)->create();

    User::create([
      'name' => 'Pedro Luis',
      'email' => 'luiskonkut@gmail.com',
      'password' => bcrypt('12345678')
    ])->assignRole('Administrador');

    User::create([
      'name' => 'Ibeth Pamela',
      'email' => 'ibeth@gmail.com',
      'password' => bcrypt('12345678')
    ])->assignRole('Administrador');

    User::create([
      'name' => 'Jesus',
      'email' => 'jesus@gmail.com',
      'password' => bcrypt('12345678')
    ])->assignRole('Caja');

    User::create([
      'name' => 'Cameron',
      'email' => 'cameron@gmail.com',
      'password' => bcrypt('12345678')
    ])->assignRole('Caja');

      User::create([
          'name' => 'Tatiana',
          'email' => 'tatiana@gmail.com',
          'password' => bcrypt('12345678')
      ])->assignRole('Administrador');
  }
}
