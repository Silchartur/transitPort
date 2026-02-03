<?php

namespace App\Http\Controllers;

use App\Models\Contenedor;
use Illuminate\Http\Request;

class ContenedoresController extends Controller
{
     public function obtenerContenedor() {

        $contenedor = Contenedor::all();

        return response()->json($contenedor);
    }

    public function crearContenedor(Request $request) {

        $validatedData = $request->validate([
            'num_serie' => 'required|string',
            'companyia' => 'required|string',
            'existe' => 'required|boolean',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $contenedor = Contenedor::create($validatedData);

            return response()->json([
                'message' => 'Buque creado con éxito.',
                'contenedor' => $contenedor
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear el contenedor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function buscarBuquePorId($id) {

        $contenedor = Contenedor::findOrFail($id);

        return $contenedor;
    }

    public function modificarBuque(Request $request) {

        $validatedData = $request->validate([
           'num_serie' => 'required|string',
            'companyia' => 'required|string',
            'existe' => 'required|boolean',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $contenedor = Contenedor::findOrFail($request['id']);
            $contenedor->update($validatedData);

            return response()->json([
                'message' => 'Buque actualizado con éxito.',
                'buque' => $contenedor
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al actualizar el contenedor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
