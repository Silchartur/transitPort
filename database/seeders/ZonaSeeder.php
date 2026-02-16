<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        // 12 zonas de patio
        for ($i = 1; $i <= 12; $i++) {
            Zona::create([
                'tipo' => 'patio',
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 5 zonas de descarga
        for ($i = 1; $i <= 5; $i++) {
            Zona::create([
                'tipo' => 'descarga',
                'activa' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
