<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenesController extends Controller
{

    function listadoOrdenes() {

        $ordenes = Orden::with(['contenedor', 'gruas', 'operarios', 'buque', 'parking'])->get();

        $ordenesAMostrar = $ordenes->map(function ($orden) {

            $gruaSTS = $orden->gruas->where('tipo', 'sts')->first();
            $gruaSC = $orden->gruas->where('tipo', 'sc')->first();

            $operarioSTS = $orden->operarios->first(function ($operario) use ($gruaSTS) {
                return $gruaSTS->operarios->contains('id', $operario->id);
            });

            $operarioSC = $orden->operarios->first(function ($operario) use ($gruaSC) {
                return $gruaSC->operarios->contains('id', $operario->id);
            });

            return [
                'id' => $orden->id,
                'tipo' => $orden->tipo,
                'contenedor' => $orden->contenedor->id,
                'grua_sts' => $gruaSTS->id,
                'grua_sc' => $gruaSC->id,
                'operario_sts' => $operarioSTS->id,
                'operario_sc' => $oeprarioSC->id,
                'buque' => $orden->buque->id,
                'parking' => $orden->parking->id
            ]
        })

        return response()->json($ordenes);
    }

    function actualizarEstado($id) {

        $orden = Orden::findOrFail($id);

        if($orden->tipo == 'descarga') {

            if($orden->estado == 'pendiente') {
                $orden->estado = 'en_proceso_sts';
                $orden->save();

                $gruaSTS = $orden->gruas()->where('tipo', 'sts');
                $operarios = $orden->operarios();

            }

        }

    }
}
