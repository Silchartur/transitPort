<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\OrdenDeTrabajo;


class OrdenDeTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for($i = 0; $i < 12; $i++) {
            OrdenDeTrabajo::create([
                'tipo' => $faker->randomElement(['carga', 'descarga']),
                'estado' => $faker->randomElement(['pendiente', 'en curso', 'completada']),
                'prioridad' => $faker->randomElement(['alta', 'media', 'baja']),

                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
        }
    }
}
