<?php

namespace App\Http\Controllers;
use App\Models\Zona;
use Illuminate\Http\Request;

class ZonasController extends Controller
{
    public function obtenerZonas() {

        $zonas = Zona::all();

        return response()->json($zonas);
    }

    public function buscarZonaPorId($id) {

        $zona = Zona::findOrFail($id);

        return $zona;
    }

    public function modicarEstadoZona($id) {

        $zona = Zona::findOrFail($id);

        $zona->activa = !$zona->activa;
        $zona->save();
    }
}
