<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use Illuminate\Http\Request;

class AdministrativosController extends Controller
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

        $administrativo = Administrativo::findOrFail($id);

        $administrativo->name = $request->name;
        $administrativo->email = $request->email;
        $administrativo->apellidos = $request->apellidos;
        $administrativo->telefono = $request->telefono;
        $administrativo->observaciones = $request->observaciones;

        $administrativo->save();

        return redirect()
            ->route('listadoUsuarios', [
                'rol' => 'administrativo',
                'id' => $administrativo->id
            ])
            ->with('success', 'Administrativo actualizado correctamente');
    }
}
