<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for($i = 0; $i < 12; $i++) {
            Zona::create([
                'tipo' => $faker->randomElement(['patio', 'descarga']),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
        }

    }
}
