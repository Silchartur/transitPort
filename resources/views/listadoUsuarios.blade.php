<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial;

            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        h1 {
            color: #2f5876;
            margin-top: 0;

        }

        .main {
            display: flex;
            height: 100%
        }


        /* CONTENIDO */
        .contenido {
            flex: 1;
            display: flex
        }

        /* LISTADO */
        .listado {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .barra-filtros {
            display: flex;
            justify-content: start;
            margin-bottom: 10px;
        }

        .lista-scroll {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .usuario-card {
            background: #DFECF5;
            color:#2A5677;
            border-radius: 14px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.12);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .usuario-info {
            display: flex;
            gap: 50px
        }

        .avatar {
            border-radius: 50%;
            height: 100px
        }

        .btn-detalle {
            background: #5e7f98;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
        }

        /* PANEL DERECHO */
        .detalle {
            width: 30%;
            background: #B7D0E1;
            padding: 25px;
            border-radius: 25px 0 0 25px;
        }

        .panel-detalle input {
            width: 100%;
            padding: 9px;
            border: none;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        /* BOTONES */
        .barra-acciones {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 12px 0 5px;
        }

        .btn-accion {
            background: #5e7f98;
            color: white;
            display: flex;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            cursor: pointer;
        }

        /* PAGINACIÓN */
        .paginacion {
            text-align: center;
            margin-top: 15px;
        }

        .paginacion a {
            margin: 0 5px;
            padding: 6px 12px;
            background: #5e7f98;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .filtro_busqueda {
            display: flex;
            justify-content: space-between;
        }

        .btn-anyadir {
            display: flex;
            justify-content: center;
            padding-top: 20px;
        }

        .btn-volver {
            color: #dce7ef;
            background-color: #5F84A2;
            width: 85px;
            height: 40px;
        }

        h2{
            color: #2A5677;
        }
    </style>
</head>

<body>

    <div class="main">

        <div class="contenido">

            @php
                $todos = $gestores->concat($administrativos)->concat($operarios);

                $porPagina = 8;
                $pagina = request()->get('page', 1);
                $inicio = ($pagina - 1) * $porPagina;

                $usuariosPagina = $todos->slice($inicio, $porPagina);
                $totalPaginas = ceil($todos->count() / $porPagina);
            @endphp

            <div class="listado {{ $usuarioSeleccionado ? 'modo-lista' : 'modo-grid' }}">

                <h1>Listado de usuarios</h1>

                <div class="filtro_busqueda">
                    <div class="barra-filtros">
                        <label for="opciones">Filtrar por: </label>
                        <br>
                        <select name="opciones" id="opciones">
                            <option value="todos">Todos Roles</option>
                            <option value="gestor">Gestor</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="operario">Operario</option>
                        </select>
                    </div>

                    <div class="barra-busqueda">
                        <input type="text" name="" id="">
                    </div>
                </div>

                <div class="lista-scroll">

                    @foreach ($usuariosPagina as $usuario)
                        <div class="usuario-card" data-nombre="{{ strtolower($usuario->name) }}"
                            data-rol="{{ strtolower($usuario->rol) }}" data-id="{{ $usuario->id }}">

                            <div class="usuario-info">
                                <img src="{{ $usuario->imagen }}" class="avatar">
                                <div>
                                    <strong>{{ $usuario->name }}</strong>
                                    <strong> {{ $usuario->apellidos }}</strong><br><br>
                                    <small>Rol: {{ ucfirst($usuario->rol) }}</small>
                                </div>
                            </div>

                            <form method="GET" action="{{ route('listadoUsuarios') }}">
                                <input type="hidden" name="id" value="{{ $usuario->id }}">
                                <input type="hidden" name="rol" value="{{ $usuario->rol }}">
                                <button class="btn-detalle">Detalles</button>
                            </form>

                        </div>
                    @endforeach

                </div>

                <div class="paginacion">
                    @for ($i = 1; $i <= $totalPaginas; $i++)
                        <a href="{{ route('listadoUsuarios', ['page' => $i]) }}">{{ $i }}</a>
                    @endfor
                </div>

                <div class="btn-anyadir">
                    <form action="{{ route('registrar') }}" method="GET">
                        <button type="submit" class="btn-accion">Añadir usuario +</button>
                    </form>
                </div>


            </div>

            @if ($usuarioSeleccionado)
                <div class="detalle">
                    <div class="panel-detalle">

                        <form method="GET" action="{{ route('listadoUsuarios') }}">
                            <button class="btn-volver"><svg xmlns="http://www.w3.org/2000/svg" width="32"
                                    height="32" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z">
                                    </path>
                                </svg></button>
                        </form>

                        <h2>Detalles del usuario</h2>

                        <form method="POST" action="{{ route($rol . '_update', $usuarioSeleccionado->id) }}">
                            @csrf
                            @method('PUT')
                            <label for="name">Nombre: </label>
                            <input name="name" value="{{ $usuarioSeleccionado->name }}" disabled>
                            <label for="apellidos">Apellidos: </label>
                            <input name="apellidos" value="{{ $usuarioSeleccionado->apellidos }}" disabled>
                            <label for="email">Email: </label>
                            <input name="email" value="{{ $usuarioSeleccionado->email }}" disabled>
                            <label for="telefono">Teléfono: </label>
                            <input name="telefono" value="{{ $usuarioSeleccionado->telefono }}" disabled>
                            <label for="observaciones">Observaciones: </label>
                            <input name="observaciones" value="{{ $usuarioSeleccionado->observaciones }}" disabled>

                            <button type="button" onclick="activarEdicion()">Editar</button>
                            <button type="submit" id="btnGuardar" hidden>Guardar</button>

                        </form>

                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function activarEdicion() {
            document.querySelectorAll('.panel-detalle input')
                .forEach(el => el.disabled = false);
            document.getElementById('btnGuardar').hidden = false;
        }
    </script>

</body>

</html>
