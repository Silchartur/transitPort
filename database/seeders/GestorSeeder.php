<?php

namespace Database\Seeders;

use App\Models\Gestor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class GestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 10; $i++) {
            Gestor::create([
                'nombre' => $faker->firstName(),
                'apellidos' => $faker->lastName(),
                'email' => $faker->email(),
                'telefono' => $faker->buildingNumber(),
                'imagen' => $faker->url(),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
        }
    }
}
