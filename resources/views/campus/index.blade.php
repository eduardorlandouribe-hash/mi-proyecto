<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Campus Virtual - UCC</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/campusIndex.css') }}">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-logo">
            <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
        </div>

        <div class="header-acciones">
            <button class="icon-btn" title="Aplicaciones"><i class="fas fa-th"></i></button>
            <button class="icon-btn" title="Mensajes"><i class="fas fa-envelope"></i><span class="badge">3</span></button>
            <button class="icon-btn" title="Chat"><i class="fas fa-comment-dots"></i></button>
            <button class="icon-btn" title="Notificaciones"><i class="fas fa-bell"></i></button>
            <div class="separador"></div>
            <div class="usuario-info">
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <span class="usuario-nombre">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="icon-btn" title="Cerrar sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- BODY -->
    <main class="main">

        <div class="bienvenida">
            <h1>Bienvenido, <span>{{ Auth::user()->name }}</span> 👋</h1>
            <p>Aquí están tus materias del semestre actual.</p>
        </div>

        <div class="materias-grid" id="materiasGrid">

            @if($materias->isEmpty())
                <p style="color: var(--muted)">No tienes materias asignadas aún.</p>
            @else
                @foreach($materias as $materia)
                <div class="tarjeta-materia">
                    <div class="tarjeta-banner" style="background: {{ $materia->color ?? '#00aaaa' }}">
                        <span>{{ $materia->emoji ?? '📚' }}</span>
                    </div>
                    <div class="tarjeta-body">
                        <p class="tarjeta-codigo">{{ $materia->codigo }}</p>
                        <p class="tarjeta-nombre">{{ $materia->nombre }}</p>
                        <div class="tarjeta-meta">
                            <span><i class="fas fa-user"></i> {{ $materia->docente }}</span>
                            <span><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
                        </div>
                    </div>
                    <div class="tarjeta-footer">
                        <button class="btn-entrar">Entrar →</button>
                        <span class="tarjeta-creditos">{{ $materia->creditos }} créditos</span>
                    </div>
                </div>
                @endforeach
            @endif

        </div>

    </main>

</body>
</html>