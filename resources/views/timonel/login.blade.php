<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Timonel - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/timonel-login.css') }}">
</head>
<body>
<div class="login-wrapper">

    <!-- Panel izquierdo -->
    <div class="panel-izquierdo">
        <img src="{{ asset('logos/logo.png') }}" alt="UCC" class="logo-grande"/>
        <h2>Bienvenido al <strong>Timonel</strong></h2>
        <p>Tu portal académico personal. Consulta tus materias, notas, perfil y estado financiero en un solo lugar.</p>
    </div>

    <!-- Panel derecho -->
    <div class="panel-derecho">
        <div class="form-box">
            <h2>Iniciar sesión</h2>
            <p class="subtitulo">Usa las mismas credenciales del Campus Virtual</p>

            <form method="POST" action="{{ route('timonel.login.post') }}">
                @csrf
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"/>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña"/>
                </div>

                @if ($errors->any())
                    <p style="color:red; font-size:13px; margin-top:8px;">
                        {{ $errors->first() }}
                    </p>
                @endif

                <button type="submit" class="btn-primary">
                    <span>Entrar</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

        </div>
    </div>

</div>
</body>
</html>