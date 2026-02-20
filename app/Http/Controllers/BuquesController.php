<?php

namespace App\Http\Controllers;
use App\Models\Buque;
use Illuminate\Http\Request;

class BuquesController extends Controller
{
    public function obtenerBuques() {

        $buques = Buque::all();

        return response()->json($buques);
    }

    public function obtenerBuquesConContenedores() {

        $buques = Buque::with('contenedores')->get();

        return response()->json($buques);
    }

    public function crearBuque(Request $request) {

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'capacidad' => 'required|integer',
            'estado' => 'in:inactivo,en espera, atracado',
            'observaciones' => 'nullable|string'
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

    public function buscarBuquePorId($id) {

        $buque = Buque::findOrFail($id);

        return $buque;
    }

    public function modificarBuque(Request $request) {

        $validatedData = $request->validate([
            'nombre' => 'required|string',
            'tipo' => 'required|string',
            'capacidad' => 'required|integer',
            'estado' => 'in:salido,en espera,atracado',
            'observaciones' => 'nullable|string'
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

    public function eliminarBuque($id){

        $buque = Buque::findOrFail($id);

        $buque->delete();

           return response()->json(['message' => 'Eliminado']);
    
    }

}
