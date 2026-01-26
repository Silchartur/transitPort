<?php

namespace Database\Seeders;

use App\Models\Contenedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
//protected $fillable = ['num__serie', 'companyia', 'existe'];
class ContenedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 10; $i++) {
            Contenedor::create([
                'num_serie' => $faker->buildingNumber(),
                'companyia' => $faker->company(),
                'existe' => $faker->boolean(),

            ]);
        }
    }
}
