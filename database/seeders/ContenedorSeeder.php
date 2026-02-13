<?php

namespace Database\Seeders;

use App\Models\Contenedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Buque;
use App\Models\Parking;
use App\Models\Patio;
//protected $fillable = ['num__serie', 'companyia', 'existe'];
class ContenedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create('es_ES');
        $parking = Parking::first();

        Buque::all()->each(function ($buque) use ($faker, $parking) {

            for ($i = 0; $i < 10; $i++) {
                Contenedor::create([
                    'num_serie' => $faker->numerify('CONT-#########'),
                    'companyia' => $faker->company(),
                    'existe' => $faker->boolean(),
                    'buque_id' => $buque->id,
                    'parking_id' => null,
                    'observaciones' => $faker->catchPhrase()
                ]);
            }
        });
    }
}
