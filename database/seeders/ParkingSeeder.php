<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Parking;
use App\Models\Zona;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        Zona::all()->each(function ($zona) {

            for ($i = 0; $i < 7; $i++) {
                if ($zona->tipo == 'patio') {
                    Parking::create([
                        'zona_id' => $zona->id
                    ]);
                }
            }
        });
    }
}
