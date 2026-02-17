<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Contenedor;
use App\Models\Buque;
use App\Models\Parking;

class ContenedorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $buques = Buque::all();

        if ($buques->isEmpty()) {
            return;
        }

        // Contenedores en buque
        foreach ($buques as $buque) {

            for ($i = 0; $i < 5; $i++) {

                Contenedor::create([
                    'num_serie' => $faker->unique()->numerify('CONT-########'),
                    'companyia' => $faker->company(),
                    'existe' => true,
                    'buque_id' => $buque->id,
                    'parking_id' => null,
                    'ubicacion' => 'BUQUE',
                    'observaciones' => 'En buque',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        //CONtenedores en patio
        $parkings = Parking::where('estado', 'libre')->take(10)->get();

        foreach ($parkings as $parking) {

            $buque = $buques->random();

            Contenedor::create([
                'num_serie' => $faker->unique()->numerify('CONT-########'),
                'companyia' => $faker->company(),
                'existe' => true,
                'buque_id' => $buque->id,
                'parking_id' => $parking->id,
                'ubicacion' => 'PARKING',
                'observaciones' => 'En patio',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $parking->estado = 'ocupado';
            $parking->save();
        }
    }
}
