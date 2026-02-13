<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenesController extends Controller
{

    public function listadoOrdenes() {

        try {
            $ordenes = Orden::with(['contenedor', 'gruas', 'operarioSTS', 'operarioSC', 'buque', 'parking'])->get();

            $ordenesAMostrar = $ordenes->map(function ($orden) {

                $gruaSTS = $orden->gruas->where('tipo', 'sts')->first();
                $gruaSC = $orden->gruas->where('tipo', 'sc')->first();

                $operarioSTS = $orden->operarioSTS->first();
                $operarioSC = $orden->operarioSC->first();

                return [
                    'id' => $orden->id,
                    'tipo' => $orden->tipo ?? 'sin_tipo',
                    'estado' => $orden->estado ?? 'pendiente',
                    'prioridad' => $orden->prioridad ?? 'baja',
                    'contenedor' => $orden->contenedor ?? null,
                    'grua_sts' => $gruaSTS ?? null,
                    'grua_sc' => $gruaSC ?? null,
                    'operario_sts' => $operarioSTS ?? null,
                    'operario_sc' => $operarioSC ?? null,
                    'buque' => $orden->buque ?? null,
                    'parking' => $orden->parking ?? null,
                    'observaciones' => $orden->observaciones ?? '',
                    'gruas' => $orden->gruas,
                ];
            });

            return response()->json($ordenesAMostrar);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }

    }


    function crearOrden(Request $request) {

        $request->validate([
            'tipo' => 'required',
            'contenedor_id' => 'required',
            'estado' => 'in:pendiente,en_proceso_sts,en_zona_desc,en_proceso_sc,completada',
            'prioridad' => 'in:alta,media,baja',
            'grua_sts_id' => 'required',
            'grua_sc_id' => 'required',
            'operario_sts_id' => 'required',
            'operario_sc_id' => 'required',
            'buque_id' => 'required',
            'parking_id' => 'required',
            'observaciones' => 'nullable|string'
        ]);

        $orden = Orden::create([
            'tipo' => $request->tipo,
            'contenedor_id' => $request->contenedor_id,
            'estado' => $request->estado,
            'prioridad' => $request->prioridad,
            'buque_id' => $request->buque_id,
            'parking_id' => $request->parking_id,
            'observaciones' => $request->observaciones
        ]);

        $orden->operarios()->attach([
            $request->operario_sts_id => ['tipo' => 'sts'],
            $request->operario_sc_id => ['tipo' => 'sc']
        ]);

        $orden->gruas()->attach([
            $request->grua_sts_id,
            $request->grua_sc_id
        ]);

        return response()->json($orden->load(['contenedores', 'buques', 'parkings', 'operarios', 'gruas']), 201);
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
