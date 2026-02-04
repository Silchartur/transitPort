<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenesController extends Controller
{
    function actualizarEstado($id) {

        $orden = Orden::findOrFail($id);

        if($orden->tipo == 'descarga') {

            if($orden->estado == 'pendiente') {
                $orden->estado = 'en_proceso_sts';
                $orden->save();

                $gruaSTS = $orden->gruas()->where('tipo', 'sts');

            }

        }

    }
}
