<?php

namespace App\Http\Controllers;

use App\Models\Contenedor;
use App\Models\Grua;
use App\Models\Parking;
use App\Models\Patio;
use App\Models\Zona;
use Illuminate\Http\Request;

class PatiosController extends Controller
{
   public function index()
    {
        return response()->json([
            'zonas_descarga' => $this->zonasDescarga(),
            'sts' => $this->sts(),
            'sc' => $this->sc(),
            'patio' => $this->patio()
        ]);
    }


    private function zonasDescarga()
    {
        $zonas = Zona::where('tipo', 'descarga')->get();

        $resultado = [];

        foreach ($zonas as $zona) {

            // Miramos si hay alguna STS ocupada en esa zona
            $grua = Grua::where('id_zona', $zona->id)
                        ->where('tipo', 'sts')
                        ->first();

            $estado = $grua ? $grua->estado : 'disponible';

            $resultado[] = [
                'codigo' => 'ZD-' . $zona->id,
                'estado' => $estado
            ];
        }

        return $resultado;
    }


    private function sts()
    {
        return Grua::where('tipo', 'sts')->get();
    }



    private function sc()
    {
        return Grua::where('tipo', 'sc')->get();
    }

   

    private function patio()
    {
        $zonas = Zona::where('tipo', 'patio')->get();

        $resultado = [];

        foreach ($zonas as $zona) {

            $parkings = Parking::where('zona_id', $zona->id)->get();

            $zonaData = [
                'zona' => 'ZP-' . $zona->id,
                'parkings' => []
            ];

            foreach ($parkings as $parking) {

            
                $ocupado = Contenedor::where('parking_id', $parking->id)->exists();

                $zonaData['parkings'][] = [
                    'codigo' => 'P-' . $parking->id,
                    'estado' => $ocupado ? 'ocupado' : 'disponible'
                ];
            }

            $resultado[] = $zonaData;
        }

        return $resultado;
    }
}
