<?php

namespace Database\Seeders;

use App\Models\Contenedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Buque;
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
        $patio = Patio::first();

        Buque::all()->each(function ($buque) use ($faker, $patio) {

            for ($i = 0; $i < 10; $i++) {
                Contenedor::create([
                    'num_serie' => $faker->numerify('CONT-#########'),
                    'companyia' => $faker->company(),
                    'existe' => $faker->boolean(),
                    'buque_id' => $buque->id,
                    'patios_id' => $patio->id
                ]);
            }
        });
    }
}
