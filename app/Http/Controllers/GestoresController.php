<?php

namespace App\Http\Controllers;

use App\Models\Gestor;
use Illuminate\Http\Request;

class GestoresController extends Controller
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

        $gestor = Gestor::findOrFail($id);

        $gestor->name = $request->name;
        $gestor->email = $request->email;
        $gestor->apellidos = $request->apellidos;
        $gestor->telefono = $request->telefono;
        $gestor->observaciones = $request->observaciones;

        $gestor->save();

        return redirect()
            ->route('listadoUsuarios', [
                'rol' => 'gestor',
                'id' => $gestor->id
            ])
            ->with('success', 'Gestor actualizado correctamente');
    }
}
