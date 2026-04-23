<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Timonel - UCC</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/timonel.css') }}">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-logo">
            <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
        </div>
        <div class="header-acciones">
            <button class="icon-btn" title="Notificaciones">
                <i class="fas fa-bell"></i>
            </button>
            <div class="separador"></div>
            <div class="usuario-info">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <span class="usuario-nombre">{{ $user->name }}</span>
            </div>
            <form method="POST" action="{{ route('timonel.logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="icon-btn" title="Cerrar sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- MAIN -->
    <main class="main">

        <div class="bienvenida">
            <h1>Hola, <span>{{ $user->name }}</span> 👋</h1>
            <p>¿Qué quieres consultar hoy?</p>
        </div>

        <div class="tarjetas-grid">

            <div class="tarjeta" style="--color: #00aaaa">
                <div class="tarjeta-icono">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="tarjeta-info">
                    <h3>Mis Materias</h3>
                    <p>Consulta las materias inscritas en el semestre actual</p>
                </div>
                <i class="fas fa-arrow-right tarjeta-flecha"></i>
            </div>

            <div class="tarjeta" style="--color: #8b5cf6">
                <div class="tarjeta-icono">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="tarjeta-info">
                    <h3>Mi Perfil</h3>
                    <p>Ve y edita tu información personal y académica</p>
                </div>
                <i class="fas fa-arrow-right tarjeta-flecha"></i>
            </div>

            <div class="tarjeta" style="--color: #10b981">
                <div class="tarjeta-icono">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="tarjeta-info">
                    <h3>Mis Notas</h3>
                    <p>Revisa tus calificaciones por materia y semestre</p>
                </div>
                <i class="fas fa-arrow-right tarjeta-flecha"></i>
            </div>

            <div class="tarjeta" style="--color: #f59e0b">
                <div class="tarjeta-icono">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="tarjeta-info">
                    <h3>Financiero</h3>
                    <p>Consulta el estado de tu matrícula y pagos pendientes</p>
                </div>
                <i class="fas fa-arrow-right tarjeta-flecha"></i>
            </div>

            @if($user->rol === 'admin')
            <div class="tarjeta" style="--color: #ef4444">
                <div class="tarjeta-icono">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="tarjeta-info">
                    <h3>Panel Admin</h3>
                    <p>Gestiona materias, estudiantes y configuración</p>
                </div>
                <a href="{{ route('timonel.admin') }}" class="tarjeta-flecha">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif

        </div>
    </main>

</body>
</html>