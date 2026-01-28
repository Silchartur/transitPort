<?php

namespace App\Http\Controllers;
use App\Models\Buque;
use Illuminate\Http\Request;

class BuquesController extends Controller
{
    public function obtenerBuques(Request $request) {

        $buques = Buque::all();

        return $buques;
    }

    public function crearBuque(Request $request) {

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'capacidad' => 'required|integer:strict',
            'estado' => 'in:salido,en espera, atracado',
            'observaciones' => 'nullable'
        ]);

        try {
            $buque = Buque::create($validatedData);

            return response()->json([
                'message' => 'Buque creado con éxito.',
                'buque' => $buque
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al crear el buque',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function buscarBuquePorId(Request $request) {

        $buque = Buque::findOrFail($request->id);

        return $buque;
    }

    public function modificarBuque(Request $request) {

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'capacidad' => 'required|integer:strict',
            'estado' => 'in:salido,en espera, atracado'
        ]);

        try {
            $buque = Buque::findOrFail($request['id']);
            $buque->update($validatedData);

            return response()->json([
                'message' => 'Buque actualizado con éxito.',
                'buque' => $buque
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error al actualizar el buque.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function eliminarBuque(Request $request) {

        $buque = Buque::destroy($request->id);

        return response()->json([
            'message' => 'Buque con id '. $buque .' borrado con éxito.'
        ], 201);
    }
}
