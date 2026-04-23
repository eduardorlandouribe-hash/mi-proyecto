<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Virtual - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/Campus.css') }}">
</head>
<body>
<div class="container">
    <div class="box">
        <h2>Registrarse</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Nombre completo" value="{{ old('name') }}">
            <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Contraseña">
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña">
            <button type="submit">Registrarse</button>
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>

        </form>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div style="color:red; margin-top:10px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

    </div>
</div>

<script>
function toggleCodigo() {
    const rol = document.getElementById('rol').value;
    const campo = document.getElementById('campoCodigo');
    campo.classList.toggle('hidden', rol !== 'admin');
}
</script>

</body>
</html>