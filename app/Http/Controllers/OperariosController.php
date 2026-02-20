<?php

namespace App\Http\Controllers;

use App\Models\Operario;
use App\Models\Grua;
use Illuminate\Http\Request;

class OperariosController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'apellidos' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string'
        ]);

        $operario = Operario::findOrFail($id);

        $operario->name = $request->name;
        $operario->email = $request->email;
        $operario->apellidos = $request->apellidos;
        $operario->telefono = $request->telefono;
        $operario->observaciones = $request->observaciones;

        $operario->save();

        return redirect()
            ->route('listadoUsuarios', [
                'rol' => 'operario',
                'id' => $operario->id
            ])
            ->with('success', 'Operario actualizado correctamente');
    }

    public function obtenerOperarios() {
        $operarios = Operario::all();

        return response()->json($operarios);
    }

    public function obtenerGruasOperario($id) {

        $operario = Operario::findOrFail($id);
        $gruas = $operario->gruas;

        return response()->json($gruas);
    }
}
