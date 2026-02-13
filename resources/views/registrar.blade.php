<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <style>
        /* Estilos generales de la página */
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }

        /* Contenedor principal (el cuadro azul) */
        .card-container {
            background-color: #B7D0E1;
            width: 700px;
            padding: 40px 70px;
            border-radius: 50px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            position: relative;
        }

        h2 {
            color: #2A5677;
            font-size: 1.875rem;
            font-weight: bold;
            margin-bottom: 30px;
            margin-top: 10px;
        }

        /* Estructura del formulario */
        .formulario-grid {
            color: #2A5677;
        }

        .linea {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 20px;
        }

        .columna {
            display: flex;
            flex-direction: column;
            width: 50%;
        }

        .ancho-completo {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-bottom: 20px;
        }

        /* Estilo de los Inputs y Selects */
        label {
            font-weight: 500;
        }

        input, select, textarea {
            background-color: white;
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            color: #6b7280;
            margin-top: 12px;
            width: 100%;
            box-sizing: border-box;
            outline: none;
        }

        select {
            height: 38px;
        }

        /* Estilo para el botón de Volver */
        .btn-volver {
            color: #dce7ef;
            background-color: #5F84A2;
            width: 60px;
            height: 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn-volver:hover {
            background-color: #2A5677;
        }

        /* Botón con efecto Hover */
        .btn-submit {
            background-color: #5F84A2;
            color: white;
            font-weight: bold;
            padding: 10px 40px;
            border-radius: 5px;
            font-size: 1.125rem;
            border: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #DFECF5;
            color: #5F84A2;
            border-color: #5F84A2;
        }

        /* Estilo para mensajes de error */
        .error-container {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .icon-back {
            transform: rotate(180deg); /* Volteamos la flecha que tenías en detalles */
        }
    </style>
</head>

<body>

    <div class="card-container">

        <a href="{{ route('listadoUsuarios') }}" class="btn-volver">
            <svg class="icon-back" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 256 256">
                <path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"></path>
            </svg>
        </a>

        <h2>Añadir nuevo usuario</h2>

        @if ($errors->any())
            <div class="error-container">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="formulario-grid" method="POST" action="{{ route('registro') }}" enctype="multipart/form-data">
            @csrf

            <div class="linea">
                <div class="columna">
                    <label>Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="columna">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required>
                </div>
            </div>

            <div class="linea">
                <div class="columna">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="columna">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}">
                </div>
            </div>

            <div class="linea">
                <div class="columna">
                    <label>Contraseña</label>
                    <input type="password" name="password" required>
                </div>
                <div class="columna">
                    <label>Rol</label>
                    <select name="rol" required>
                        <option value="">-- Selecciona rol --</option>
                        <option value="gestor" {{ old('rol') == 'gestor' ? 'selected' : '' }}>Gestor</option>
                        <option value="administrativo" {{ old('rol') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                        <option value="operario" {{ old('rol') == 'operario' ? 'selected' : '' }}>Operario</option>
                    </select>
                </div>
            </div>

            <div class="ancho-completo">
                <label>Imagen de usuario</label>
                <input type="file" name="imagen">
            </div>

            <div class="ancho-completo">
                <label>Observaciones</label>
                <textarea name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
            </div>

            <div style="display: flex; justify-content: center;">
                <button type="submit" class="btn-submit">Crear usuario</button>
            </div>

        </form>
    </div>

</body>
</html>
