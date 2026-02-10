<?php

namespace App\Http\Controllers;
use App\Models\Grua;
use Illuminate\Http\Request;

class GruasController extends Controller
{
    public function obtenerGruas() {

        $gruas = Grua::all();

        return response()->json($gruas);
    }

    public function crearGrua(Request $request) {

        $validatedData = $request->validate([
            'tipo' => 'required|string',
            'gestor' => 'required',
            'estado' => 'in:disponible,ocupada',
            'operario' => 'required',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $grua = Grua::create($validatedData);

            return response()->json([
                'message' => 'Grúa creada con éxito.',
                'grua' => $grua
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear el buque',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function buscarGruaPorId($id) {

        $grua = Grua::findOrFail($id);

        return $grua;
    }

    public function modificarGrua(Request $request) {

        $validatedData = $request->validate([
            'tipo' => 'required|string',
            'gestor' => 'required',
            'estado' => 'in:disponible,ocupada',
            'operario' => 'required',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $grua = Grua::findOrFail($request['id']);
            $grua->update($validatedData);

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
}
