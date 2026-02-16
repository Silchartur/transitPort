<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parking;
use App\Models\Zona;

class ParkingSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = Zona::where('tipo', 'patio')->get();

        foreach ($zonas as $zona) {

            for ($i = 1; $i <= 7; $i++) {

                Parking::create([
                    'zona_id' => $zona->id,
                    'estado' => 'libre',
                    'activa' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
