<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mi Perfil — Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}"/>
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="header-logo">
      <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
    </div>
    <div class="header-acciones">
      <div class="usuario-info">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <span class="usuario-nombre">{{ $user->name }}</span>
        <span class="rol-badge {{ $user->rol }}">{{ ucfirst($user->rol) }}</span>
      </div>
      <div class="separador"></div>
      <form method="POST" action="{{ route('timonel.logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="icon-btn logout" title="Cerrar sesión">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </header>

  <!-- MAIN -->
  <main class="main" style="max-width:760px;">

    <div class="pagina-header">
      <h1>Mi Perfil</h1>
      <p>Consulta y edita tu información personal.</p>
    </div>

    <!-- Tarjeta de perfil -->
    <div class="perfil-card">
      <div class="avatar-grande">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
      <div class="perfil-info">
        <span class="perfil-nombre">{{ $user->name }}</span>
        <span class="perfil-correo">{{ $user->email }}</span>
        <div class="perfil-rol">
          <span class="rol-badge {{ $user->rol }}">{{ ucfirst($user->rol) }}</span>
        </div>
      </div>
    </div>

    @if(session('success'))
      <p style="color:green; font-weight:600; margin-bottom:16px;">
        {{ session('success') }}
      </p>
    @endif
    @if($errors->any())
      <p style="color:red; font-weight:600; margin-bottom:16px;">
        {{ $errors->first() }}
      </p>
    @endif

    <!-- Formulario -->
    <div class="form-card">

      <div class="form-card-header">
        <i class="fas fa-pen"></i>
        <h2>Editar información</h2>
      </div>

      <form method="POST" action="{{ route('timonel.perfil.update') }}">
        @csrf
        @method('PATCH')

        <div class="form-card-body">

          <div class="form-seccion-titulo">Datos personales</div>

          <div class="campo-fila">
            <div class="campo-grupo">
              <label>Nombre completo</label>
              <input type="text" name="name"
                     value="{{ old('name', $user->name) }}"
                     placeholder="Tu nombre completo"/>
            </div>
            <div class="campo-grupo">
              <label>Correo electrónico</label>
              <input type="email" name="email"
                     value="{{ old('email', $user->email) }}"
                     placeholder="tu@correo.com"/>
            </div>
          </div>

          <div class="form-seccion-titulo">Cambiar contraseña</div>

          <div class="campo-grupo">
            <label>Contraseña actual</label>
            <div class="input-wrap">
              <input type="password" name="password_actual"
                     id="inputPassActual" placeholder="••••••••"/>
              <i class="fas fa-eye" onclick="togglePass('inputPassActual', this)"></i>
            </div>
          </div>

          <div class="campo-fila">
            <div class="campo-grupo">
              <label>Nueva contraseña</label>
              <div class="input-wrap">
                <input type="password" name="password"
                       id="inputPassNueva" placeholder="••••••••"/>
                <i class="fas fa-eye" onclick="togglePass('inputPassNueva', this)"></i>
              </div>
            </div>
            <div class="campo-grupo">
              <label>Confirmar nueva contraseña</label>
              <div class="input-wrap">
                <input type="password" name="password_confirmation"
                       id="inputPassConfirm" placeholder="••••••••"/>
                <i class="fas fa-eye" onclick="togglePass('inputPassConfirm', this)"></i>
              </div>
            </div>
          </div>

        </div>

        <div class="form-card-footer">
          @if(session('success'))
            <div class="msg-exito visible">
              <i class="fas fa-check-circle"></i> Cambios guardados correctamente.
            </div>
          @else
            <div class="msg-exito" id="msgExito"></div>
          @endif
          <button type="submit" class="btn-guardar-perfil">
            <i class="fas fa-save"></i> Guardar cambios
          </button>
        </div>

      </form>
    </div>

  </main>

  <script>
    function togglePass(inputId, icono) {
      const input = document.getElementById(inputId);
      if (input.type === 'password') {
        input.type = 'text';
        icono.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icono.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>

</body>
</html>