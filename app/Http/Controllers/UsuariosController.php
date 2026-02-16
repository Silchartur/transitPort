<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\Gestor;
use App\Models\Operario;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuariosController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request, $rol)
    {
        if (!in_array($rol, ['gestor', 'administrativo', 'operario'])) {
            return response()->json(['message' => 'Rol inválido'], 400);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Elegimos modelo según rol
        switch ($rol) {
            case 'gestor':
                $model = Gestor::class;
                break;

            case 'administrativo':
                $model = Administrativo::class;
                break;

            case 'operario':
                $model = Operario::class;
                break;
        }

        $user = $model::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // Crear token Passport
        $token = $user->createToken('TokenUsuario')->accessToken;

        return response()->json([
            'success' => [
                'token' => $token,
                'name' => $user->name,
                'id' => $user->id,
                'rol' => $rol,
            ]
        ]);
    }


    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'No autorizado'
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => [
                'message' => 'Has salido correctamente'
            ]
        ]);
    }

    public function listadoUsuarios(Request $request)
    {
        $gestores = Gestor::all()->each(function ($g) {
            $g->rol = 'gestor';
        });

        $administrativos = Administrativo::all()->each(function ($a) {
            $a->rol = 'administrativo';
        });

        $operarios = Operario::all()->each(function ($o) {
            $o->rol = 'operario';
        });

        $usuarioSeleccionado = null;
        $rol = $request->rol;

        if ($request->id && $rol) {

            $models = [
                'gestor' => Gestor::class,
                'administrativo' => Administrativo::class,
                'operario' => Operario::class,
            ];

            if (isset($models[$rol])) {
                $usuarioSeleccionado = $models[$rol]::findOrFail($request->id);
            }
        }

        return view('listadoUsuarios', [
            'gestores' => $gestores,
            'administrativos' => $administrativos,
            'operarios' => $operarios,
            'usuarioSeleccionado' => $usuarioSeleccionado,
            'rol' => $rol
        ]);
    }



    public function registro(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'rol' => 'required|in:gestor,administrativo,operario',
            'observaciones' => 'nullable|string',
            'telefono' => 'nullable|string',
            'imagen' => 'nullable'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'observaciones' => $request->observaciones,
                'password' => Hash::make($request->password),
                'imagen' => $request->imagen
            ];

            switch ($request->rol) {
                case 'gestor':
                    $gestor = Gestor::create($data);
                    $gestor->createToken('TokenUsuario')->accessToken;
                    break;

                case 'administrativo':
                    $administrativo = Administrativo::create($data);
                    $administrativo->createToken('TokenUsuario')->accessToken;
                    break;

                case 'operario':
                    $operario = Operario::create($data);
                    $operario->createToken('TokenUsuario')->accessToken;
                    break;
            }

            // Redirige a la ruta que carga la vista con todos los usuarios
            return redirect()->route('listadoUsuarios');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo registrar el usuario.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function borrarUsuario($rol, $id)
    {
        switch ($rol) {
            case 'gestor':
                $model = Gestor::class;
                break;

            case 'administrativo':
                $model = Administrativo::class;
                break;

            case 'operario':
                $model = Operario::class;
                break;

            default:
                return response()->json(['error' => 'Rol no válido'], 400);
        }

        $model::where('id', $id)->delete();

        return redirect()->route('listadoUsuarios')->with('success', 'Usuario eliminado');
    }
}
