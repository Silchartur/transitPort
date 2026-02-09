<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de usuario</title>
</head>

<body>

<h2>Añadir nuevo usuario</h2>

@if ($errors->any())
<div style="color:red;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('registro') }}" enctype="multipart/form-data">
@csrf

<div>
    <label>Nombre</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
</div>

<div>
    <label>Apellidos</label>
    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required>
</div>

<div>
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
</div>

<div>
    <label>Teléfono</label>
    <input type="text" name="telefono" value="{{ old('telefono') }}">
</div>

<div>
    <label>Observaciones</label>
    <input type="text" name="observaciones" value="{{ old('observaciones') }}">
</div>

<div>
    <label>Contraseña</label>
    <input type="password" name="password" required>
</div>

<div>
    <label>Rol</label>
    <select name="rol" required>
        <option value="">-- Selecciona rol --</option>
        <option value="gestor" {{ old('rol')=='gestor'?'selected':'' }}>Gestor</option>
        <option value="administrativo" {{ old('rol')=='administrativo'?'selected':'' }}>Administrativo</option>
        <option value="operario" {{ old('rol')=='operario'?'selected':'' }}>Operario</option>
    </select>
</div>

<div>
    <label>Imagen de usuario</label>
    <input type="file" name="imagen">
</div>

<br>

<button type="submit">Crear usuario</button>

</form>

</body>
</html>
