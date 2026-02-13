<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Orden;


class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for($i = 0; $i < 12; $i++) {
            Orden::create([
                'tipo' => $faker->randomElement(['carga', 'descarga']),
                'estado' => $faker->randomElement(['pendiente', 'en_proceso_sts', 'en_zona_desc', 'en_proceso_sc', 'completada']),
                'prioridad' => $faker->randomElement(['alta', 'media', 'baja']),
                'administrativo_id' => $faker->randomElement([1, 2, 3, 4]),
                'contenedor_id' => $faker->randomElement([1, 2, 3, 4]),
                'parking_id' => $faker->randomElement([1, 2, 3, 4]),
                'buque_id' => $faker->randomElement([1, 2, 3, 4]),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'observaciones' => $faker->catchPhrase()
            ]);
        }
    }
}
