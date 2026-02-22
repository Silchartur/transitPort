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

        h1 { color: #2f5876; margin-top: 0; }

        .main { display: flex; height: 100% }

        /* CONTENIDO */
        .contenido { flex: 1; display: flex }

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
            align-items: center;
            gap: 10px;
        }

        .lista-scroll {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .usuario-card {
            background: #DFECF5;
            color: #2A5677;
            border-radius: 14px;
            padding: 10px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.12);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .usuario-info { display: flex; gap: 50px }

        .avatar { border-radius: 50%; height: 100px; width: 100px; object-fit: cover; }

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
        .btn-accion {
            background: #5e7f98;
            color: white;
            display: flex;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            cursor: pointer;
        }

        .paginacion { text-align: center; margin-top: 15px; }
        .paginacion a {
            margin: 0 5px;
            padding: 6px 12px;
            background: #5e7f98;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }
        .paginacion a.active { background: #2A5677; }


        .filtro_busqueda {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }

        .contenedor-busqueda {
            position: relative;
            display: flex;
            align-items: center;
        }

        .icono-lupa {
            position: absolute;
            left: 10px;
            fill: #5e7f98;
        }

        .input-busqueda {
            padding: 9px 10px 9px 35px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 220px;
            outline: none;
        }

        .btn-anyadir { display: flex; justify-content: center; padding-top: 20px; }

        .btn-volver {
            color: #dce7ef;
            background-color: #5F84A2;
            width: 85px;
            height: 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .btn-borrar {
            background: #c94c4c;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .usuario-card:hover .btn-borrar { opacity: 1; visibility: visible; }
    </style>
</head>

<body>

    <div class="main">
        <div class="contenido">

            @php
                // Captura de datos para el filtro
                $search = request('search');
                $rolFilter = request('rol_filter', 'todos');

                // Unión y filtrado
                $todos = $gestores->concat($administrativos)->concat($operarios);

                if ($search) {
                    $todos = $todos->filter(function($u) use ($search) {
                        return str_contains(strtolower($u->name . ' ' . $u->apellidos), strtolower($search));
                    });
                }

                if ($rolFilter !== 'todos') {
                    $todos = $todos->where('rol', $rolFilter);
                }

                // Paginación manual
                $porPagina = 6;
                $pagina = request()->get('page', 1);
                $inicio = ($pagina - 1) * $porPagina;
                $usuariosPagina = $todos->slice($inicio, $porPagina);
                $totalPaginas = ceil($todos->count() / $porPagina);
            @endphp

            <div class="listado {{ $usuarioSeleccionado ? 'modo-lista' : 'modo-grid' }}">

                <h1>Listado de usuarios</h1>

                <form action="{{ route('listadoUsuarios') }}" method="GET" id="formFiltros">
                    <div class="filtro_busqueda">
                        <div class="barra-filtros">
                            <label for="rol_filter">Filtrar por: </label>
                            <select name="rol_filter" id="rol_filter" onchange="this.form.submit()">
                                <option value="todos" {{ $rolFilter == 'todos' ? 'selected' : '' }}>Todos Roles</option>
                                <option value="gestor" {{ $rolFilter == 'gestor' ? 'selected' : '' }}>Gestor</option>
                                <option value="administrativo" {{ $rolFilter == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="operario" {{ $rolFilter == 'operario' ? 'selected' : '' }}>Operario</option>
                            </select>
                        </div>

                        <div class="contenedor-busqueda">
                            <svg class="icono-lupa" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 256 256">
                                <path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path>
                            </svg>
                            <input type="text" name="search" class="input-busqueda" placeholder="Buscar..." value="{{ $search }}">
                        </div>
                    </div>
                </form>

                <div class="lista-scroll">
                    @forelse ($usuariosPagina as $usuario)
                        <div class="usuario-card">
                            <div class="usuario-info">
                                <img src="{{ $usuario->imagen }}" class="avatar">
                                <div>
                                    <strong>{{ $usuario->name }} {{ $usuario->apellidos }}</strong><br><br>
                                    <small>Rol: {{ ucfirst($usuario->rol) }}</small>
                                </div>
                            </div>

                            <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
                                <form method="GET" action="{{ route('listadoUsuarios') }}">
                                    <input type="hidden" name="id" value="{{ $usuario->id }}">
                                    <input type="hidden" name="rol" value="{{ $usuario->rol }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="rol_filter" value="{{ $rolFilter }}">
                                    <button class="btn-detalle">Detalles</button>
                                </form>

                                <form action="{{ route('borrarUsuario', ['rol' => $usuario->rol, 'id' => $usuario->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-borrar">Borrar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="text-align:center; color:#2A5677;">No se han encontrado usuarios.</p>
                    @endforelse
                </div>

                <div class="paginacion">
                    @for ($i = 1; $i <= $totalPaginas; $i++)
                        <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="{{ $pagina == $i ? 'active' : '' }}">
                            {{ $i }}
                        </a>
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
                            <button class="btn-volver">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 256 256" style="transform: rotate(180deg)">
                                    <path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"></path>
                                </svg>
                            </button>
                        </form>

                        <h2>Detalles del usuario</h2>

                        <form method="POST" action="{{ route($rol . '_update', $usuarioSeleccionado->id) }}">
                            @csrf
                            @method('PUT')
                            <label>Nombre: </label>
                            <input name="name" value="{{ $usuarioSeleccionado->name }}" disabled>
                            <label>Apellidos: </label>
                            <input name="apellidos" value="{{ $usuarioSeleccionado->apellidos }}" disabled>
                            <label>Email: </label>
                            <input name="email" value="{{ $usuarioSeleccionado->email }}" disabled>
                            <label>Teléfono: </label>
                            <input name="telefono" value="{{ $usuarioSeleccionado->telefono }}" disabled>
                            <label>Observaciones: </label>
                            <input name="observaciones" value="{{ $usuarioSeleccionado->observaciones }}" disabled>

                            <button type="button" onclick="activarEdicion()" class="btn-accion">Editar</button>
                            <button type="submit" id="btnGuardar" class="btn-accion" style="margin-top:10px; background:#2f5876" hidden>Guardar</button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function activarEdicion() {
            document.querySelectorAll('.panel-detalle input').forEach(el => el.disabled = false);
            document.getElementById('btnGuardar').hidden = false;
        }
    </script>

</body>
</html>
