<?php


namespace App\Http\Controllers;


use App\Models\Contenedor;
use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;


class ContenedoresController extends Controller
{
   public function obtenerContenedor()
{
    try {
        // Forzamos a que nos diga quién está intentando entrar
        // $user = auth()->user(); 
        
        $contenedor = Contenedor::all();
        return response()->json($contenedor);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error en el servidor',
            'detalle' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}


    public function crearContenedor(Request $request)
    {
        $validatedData = $request->validate([
            'num_serie' => 'required|string',
            'companyia' => 'required|string',
            'existe' => 'required|boolean',
            'observaciones' => 'nullable|string',
            'buque_id' => 'nullable|integer',
            'parking_id' => 'nullable|integer'
        ]);


        try {
            $contenedor = Contenedor::create($validatedData);


            return response()->json($contenedor, 201);
        } catch (\Exception $e) {


            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }




    public function buscarContenedorPorId($id)
    {


        $contenedor = Contenedor::findOrFail($id);


        return $contenedor;
    }


    public function modificarContenedor(Request $request)
    {


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
                'message' => 'Contenedor actualizado con éxito.',
                'buque' => $contenedor
            ], 200);
        } catch (\Exception $e) {


            return response()->json([
                'message' => 'Error al actualizar el contenedor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function obtenerUbicacionContenedor($id)
    {
        $contenedor = Contenedor::findOrFail($id);
        $orden = Orden::where('id_contenedor', $id)->first();
        $parking = $contenedor->parking_id;
        $ubicacion = $contenedor->ubicacion;


        if (!$orden) {
            return $parking ? 'Parking' : 'Buque';
        }


        if ($orden->tipo === 'descarga') {
            switch ($orden->estado) {
                case 'en_zona_desc':
                    return 'Zona de descarga';
                case 'pendiente':
                    return 'Buque';
                case 'completada':
                    return 'Parking';
            }
        }


        if ($orden->tipo === 'carga') {
            switch ($orden->estado) {
                case 'en_zona_desc':
                    return 'Patio';
                case 'pendiente':
                    return 'Parking';
                case 'completada':
                    return 'Buque';
            }
        }
    }

    public function eliminarContenedor($id){

        $contenedor = Contenedor::findOrFail($id);

        $contenedor->delete();

           return response()->json(['message' => 'Eliminado']);
    
    }
}
