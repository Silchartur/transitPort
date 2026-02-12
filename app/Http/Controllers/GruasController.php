<?php

namespace App\Http\Controllers;
use App\Models\Grua;
use Illuminate\Http\Request;
use App\Models\Operario;
use Illuminate\Support\Facades\Log;

class GruasController extends Controller
{
    public function obtenerGruas() {

        $gruas = Grua::with('operarios')->get();

        return response()->json($gruas);
    }

    public function crearGrua(Request $request) {

        $request->validate([
            'tipo' => 'required|string',
            'id_gestor' => 'required',
            'estado' => 'in:disponible,ocupada',
            'id_zona' => 'required',
            'operarios' => 'required|array',
            'observaciones' => 'nullable|string'
        ]);

        try {

            $operariosId = $request->input('operarios');
            $data = [
                'tipo' => $request->tipo,
                'id_gestor' => $request->id_gestor,
                'estado' => $request->estado,
                'id_zona' => $request->id_zona,
                'observaciones' => $request->observaciones
            ];

            $grua = Grua::create($data);

            $grua->operarios()->attach($operariosId);

            return response()->json([
                'message' => 'Grúa creada con éxito.',
                'grua' => $grua
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear la grúa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function buscarGruaPorId($id) {

        $grua = Grua::findOrFail($id);

        return $grua;
    }

    public function modificarGrua(Request $request) {

        $request->validate([
            'tipo' => 'required|string',
            'id_gestor' => 'required',
            'estado' => 'in:disponible,ocupada',
            'id_zona' => 'required',
            'operarios' => 'required|array',
            'observaciones' => 'nullable|string'
        ]);

        try {

            $grua = Grua::findOrFail($request['id']);
            $operariosId = $request->input('operarios');
            $data = [
                'tipo' => $request->tipo,
                'id_gestor' => $request->id_gestor,
                'estado' => $request->estado,
                'id_zona' => $request->id_zona,
                'observaciones' => $request->observaciones
            ];

            $grua->update($data);
            $grua->operarios()->sync($operariosId);

            return response()->json([
                'message' => 'Grúa actualizada con éxito.',
                'grua' => $grua
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al actualizar la grúa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarGrua($id) {

        $grua = Grua::findOrFail($id);

        if (!$grua) {
            return response().json(['message' => 'Grúa no encontrada'], 404);
        }

        $grua->delete();

        return response().json(['message' => 'Grúa eliminada correctamente'], 200);
    }
}
