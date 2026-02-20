<?php

namespace App\Http\Controllers;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenesController extends Controller
{

    public function listadoOrdenes() {

        try {
            $ordenes = Orden::with(['contenedor', 'gruas', 'operario_sts', 'operario_sc', 'buque', 'parking'])->get();

            $ordenesAMostrar = $ordenes->map(function ($orden) {

                $gruaSTS = $orden->gruas->where('tipo', 'sts')->first();
                $gruaSC = $orden->gruas->where('tipo', 'sc')->first();

                $operarioSTS = $orden->operario_sts->first();
                $operarioSC = $orden->operario_sc->first();

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

        try {
            $request->validate([
                'tipo' => 'required|in:carga,descarga',
                'contenedor_id' => 'required',
                'administrativo_id' => 'required',
                'estado' => 'required|in:pendiente,en_proceso_sts,en_zona_desc,en_proceso_sc,completada',
                'prioridad' => 'required|in:alta,media,baja',
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
                'administrativo_id' => $request->administrativo_id,
                'observaciones' => $request->observaciones
            ]);

            $orden->operario_sts()->attach($request->operario_sts_id, ['tipo' => 'sts']);
            $orden->operario_sc()->attach($request->operario_sc_id, ['tipo' => 'sc']);

            $orden->gruas()->attach([
                $request->grua_sts_id,
                $request->grua_sc_id
            ]);

            //return response()->json($orden->with(['contenedor', 'buque', 'parking', 'operario_sts', 'operario_sc', 'gruas']), 201);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }

    }

    public function modificarOrden(Request $request) {

        $validatedData = $request->validate([
            'tipo' => 'required|in:carga,descarga',
            'contenedor_id' => 'required',
            'administrativo_id' => 'required',
            'estado' => 'required|in:pendiente,en_proceso_sts,en_zona_desc,en_proceso_sc,completada',
            'prioridad' => 'required|in:alta,media,baja',
            'grua_sts_id' => 'required',
            'grua_sc_id' => 'required',
            'operario_sts_id' => 'required',
            'operario_sc_id' => 'required',
            'buque_id' => 'required',
            'parking_id' => 'required',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $orden = Orden::findOrFail($request['id']);
            $orden->update($request->only([
                'tipo', 'estado', 'prioridad', 'buque_id', 'parking_id', 'contenedor_id', 'administrativo_id', 'observaciones'
            ]));

            $orden->operario_sts()->sync([
                $request->operario_sts_id => ['tipo' => 'sts']
            ]);

            $orden->operario_sc()->sync([
                $request->operario_sc_id => ['tipo' => 'sc']
            ]);

            $orden->gruas()->sync([
                $request->grua_sts_id,
                $request->grua_sc_id
            ]);

            return response()->json([
                'message' => 'Orden actualizada con éxito.',
                'orden' => $orden
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al actualizar la orden.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function actualizarEstado($id) {

        $orden = Orden::findOrFail($id);
        $user = auth()->guard('operario')->user();

        if($orden->tipo == 'descarga') {

            switch ($orden->estado ) {
                case 'pendiente':
                    if($orden->operario_sts_id == $user->id) {
                        $orden->estado = 'en_proceso_sts';
                        $orden->save();
                    }
                    break;

                case 'en_proceso_sts':
                    if($orden->operario_sts_id == $user->id) {
                        $orden->estado = 'en_zona_desc';
                        $orden->save();
                    }
                    break;

                case 'en_zona_desc':
                    if($orden->operario_sc_id == $user->id) {
                        $orden->estado = 'en_proceso_sc';
                        $orden->save();
                    }
                    break;

                case 'en_proceso_sc':
                    if($orden->operario_sc_id == $user->id) {
                        $orden->estado = 'completada';
                        $orden->save();
                    }
                    break;
            }

        } else if($orden->tipo === 'carga') {

            switch ($orden->estado ) {
                case 'pendiente':
                    if($orden->operario_sc_id == $user->id) {
                        $orden->estado = 'en_proceso_sc';
                        $orden->save();
                    }
                    break;

                case 'en_proceso_sc':
                    if($orden->operario_sc_id == $user->id) {
                        $orden->estado = 'en_zona_desc';
                        $orden->save();
                    }
                    break;

                case 'en_zona_desc':
                    if($orden->operario_sts_id == $user->id) {
                        $orden->estado = 'en_proceso_sts';
                        $orden->save();
                    }
                    break;

                case 'en_proceso_sts':
                    if($orden->operario_sts_id == $user->id) {
                        $orden->estado = 'completada';
                        $orden->save();
                    }
                    break;
            }
        }

        return response()->json(['error' => 'No tienes permiso para este cambio'], 403);
    }
}
