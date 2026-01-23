<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Parking;
use App\Models\Zona;

class ParkingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        Zona::all()->each(function ($zona) {

            for ($i = 0; $i < 12; $i++) {
                Parking::create([
                    'zona_id' => $zona->id
                ]);
            }
        });
    }
}
$table->id();
            $table->string('codigo')->unique()->nullable();
            $table->boolean('disponible')->default(true);
            $table->boolean('activa')->default(true);
            $table->foreignId('zona_id')->constrained('zonas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
