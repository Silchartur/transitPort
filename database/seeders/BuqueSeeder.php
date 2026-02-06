<?php

namespace Database\Seeders;

use App\Models\Buque;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class BuqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 100; $i++) {
            Buque::create([
                'nombre' => $faker->firstName(),
                'tipo' => $faker->catchPhrase(),
                'capacidad' => $faker->buildingNumber(),
                'estado' => $faker->randomElement(['inactivo', 'en espera', 'atracado']),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'observaciones' => $faker->catchPhrase()
            ]);
        }
    }
}
