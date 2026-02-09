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
            background: #e9edf2;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .main {
            display: flex;
            height: 100%
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: #2f5876;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
        }

        .menu-item {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #24465f
        }

        /* CONTENIDO */
        .contenido {
            flex: 1;
            display: flex
        }

        /* LISTADO */
        .listado {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
        }

        .barra-filtros {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .lista-scroll {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .usuario-card {
            background: #dce7ef;
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
            width: 40%;
            background: #9fb6c7;
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
    </style>
</head>

<body>

    <div class="main">

        <div class="sidebar">
            <h3>TRANSITPORT</h3>
            <div class="menu-item">Grúas</div>
            <div class="menu-item">Patio</div>
            <div class="menu-item active">Usuarios</div>
            <div class="menu-item">Órdenes</div>
            <div class="menu-item">Contenedores</div>
            <div class="menu-item">Buques</div>
            <div style="margin-top:auto" class="menu-item">Salir</div>
        </div>

        <div class="contenido">

            @php
                $todos = $gestores->concat($administrativos)->concat($operarios);

                $porPagina = 6;
                $pagina = request()->get('page', 1);
                $inicio = ($pagina - 1) * $porPagina;

                $usuariosPagina = $todos->slice($inicio, $porPagina);
                $totalPaginas = ceil($todos->count() / $porPagina);
            @endphp

            <div class="listado {{ $usuarioSeleccionado ? 'modo-lista' : 'modo-grid' }}">

                <h1>Listado de usuarios</h1>

                <div class="barra-filtros">
                    <div>Filtrar por:</div>
                    <input type="text" id="busqueda" placeholder="Buscar usuario">
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

                <div class="barra-acciones">
                    <form action="{{ route('registrarinicio') }}" method="GET">
                        <button class="btn-accion">Añadir usuario +</button>
                    </form>
                </div>

            </div>

            @if ($usuarioSeleccionado)
                <div class="detalle">
                    <div class="panel-detalle">

                        <form method="GET" action="{{ route('listadoUsuarios') }}">
                            <button>← Volver</button>
                        </form>

                        <h2>Detalles del usuario</h2>

                        <form method="POST" action="{{ route($rol . '_update', $usuarioSeleccionado->id) }}">
                            @csrf
                            @method('PUT')

                            <input name="name" value="{{ $usuarioSeleccionado->name }}" disabled>
                            <input name="apellidos" value="{{ $usuarioSeleccionado->apellidos }}" disabled>
                            <input name="email" value="{{ $usuarioSeleccionado->email }}" disabled>
                            <input name="telefono" value="{{ $usuarioSeleccionado->telefono }}" disabled>
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
