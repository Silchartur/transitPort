<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   <style>
    /* ... (Mantenemos tus estilos base intactos para no romper el diseño desktop) ... */
    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #f4f7f9;
        color: #333;
    }

    h1 { color: #2f5876; margin-top: 0; font-size: 1.8rem; }
    .main { min-height: 100vh; display: flex; flex-direction: column; }
    .contenido { display: flex; flex: 1; flex-direction: row; }
    .listado { flex: 1; padding: 20px; transition: all 0.3s ease; }

    .filtro_busqueda {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 20px;
        align-items: center;
    }

    .barra-filtros { display: flex; align-items: center; gap: 10px; }
    .contenedor-busqueda { position: relative; flex-grow: 1; max-width: 400px; }

    .input-busqueda {
        padding: 10px 10px 10px 35px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
    }

    .lista-scroll {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .usuario-card {
        background: #DFECF5;
        color: #2A5677;
        border-radius: 14px;
        padding: 15px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .usuario-info { display: flex; gap: 15px; align-items: center; }
    .avatar { border-radius: 50%; height: 70px; width: 70px; object-fit: cover; flex-shrink: 0; }

    .detalle {
        width: 350px;
        background: #B7D0E1;
        padding: 25px;
        border-radius: 25px 0 0 25px;
        box-shadow: -4px 0 10px rgba(0,0,0,0.05);
    }

    .panel-detalle input {
        width: 100%;
        padding: 10px;
        border: 1px solid rgba(255,255,255,0.5);
        border-radius: 8px;
        margin-bottom: 12px;
        box-sizing: border-box;
    }

    .btn-accion, .btn-detalle, .btn-borrar {
        cursor: pointer;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: transform 0.1s;
    }

    .btn-detalle { background: #5e7f98; color: white; padding: 8px 15px; }
    .btn-borrar { background: #c94c4c; color: white; padding: 6px 12px; font-size: 0.8rem; }
    .paginacion { text-align: center; margin: 20px 0; }

    /* =============================================
       NUEVOS AJUSTES EXCLUSIVOS PARA MÓVIL
    ============================================= */
    @media (max-width: 768px) {
        .contenido {
            flex-direction: column; /* Apilado vertical */
        }

        .listado {
            padding: 15px; /* Menos margen en bordes de pantalla */
        }

        .detalle {
            width: 100%;
            border-radius: 0 0 25px 25px; /* Redondeado invertido para el tope */
            order: -1; /* El detalle aparece arriba si está activo */
            padding: 20px;
            margin-bottom: 20px;
        }

        .filtro_busqueda {
            flex-direction: column;
            align-items: stretch; /* Filtros ocupan todo el ancho */
        }

        .barra-filtros select {
            flex: 1;
            padding: 10px;
        }

        .contenedor-busqueda {
            max-width: 100%; /* Lupa y búsqueda a ancho completo */
        }

        .lista-scroll {
            grid-template-columns: 1fr; /* Una sola columna de tarjetas */
        }

        .usuario-card {
            flex-direction: column; /* Apila info y botones dentro de la tarjeta */
            gap: 15px;
        }

        .usuario-info {
            width: 100%;
        }

        /* Contenedor de botones en la tarjeta para que se vean bien en móvil */
        .usuario-card > div:last-child {
            flex-direction: row !important; /* Botones uno al lado del otro */
            width: 100%;
            justify-content: flex-end;
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-top: 10px;
        }

        .btn-detalle, .btn-borrar {
            padding: 12px 20px; /* Botones más grandes para dedos (Touch targets) */
            flex: 1;
            text-align: center;
        }

        .btn-anyadir {
            position: fixed; /* Botón flotante para añadir usuario */
            bottom: 20px;
            right: 20px;
            z-index: 100;
        }

        .btn-anyadir .btn-accion {
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            padding: 15px 25px;
            border-radius: 50px;
        }

        .paginacion a {
            padding: 12px 16px; /* Números de página más fáciles de pulsar */
            margin: 5px;
        }
    }
</style>
</head>

<body>

    <div class="main">
        <div class="contenido">

            @php
                $search = request('search');
                $rolFilter = request('rol_filter', 'todos');

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
                                  <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="rol_filter" value="{{ $rolFilter }}">
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
