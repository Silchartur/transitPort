<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grua;
use App\Models\Zona;
use App\Models\Gestor;

class GruaSeeder extends Seeder
{
    public function run(): void
    {
        $gestor = Gestor::first();

        if (!$gestor) {
            return;
        }

        // STS → asociadas a zonas de descarga
        $zonasDescarga = Zona::where('tipo', 'descarga')->get();

        foreach ($zonasDescarga as $zona) {

            Grua::create([
                'tipo' => 'sts',
                'estado' => 'disponible',
                'observaciones' => 'Grua STS fija en zona descarga',
                'id_gestor' => $gestor->id,
                'id_zona' => $zona->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // SC → asociadas a zonas de patio
        $zonasPatio = Zona::where('tipo', 'patio')->get();

        foreach ($zonasPatio as $zona) {

            Grua::create([
                'tipo' => 'sc',
                'estado' => 'disponible',
                'observaciones' => 'Grua SC del patio',
                'id_gestor' => $gestor->id,
                'id_zona' => $zona->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
