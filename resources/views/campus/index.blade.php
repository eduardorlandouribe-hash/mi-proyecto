<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Campus Virtual — UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/campusIndex.css') }}"/>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="header-logo">
      <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
    </div>
    <div class="header-acciones">
      <button class="icon-btn" title="Aplicaciones">
        <i class="fas fa-th"></i>
      </button>
      <button class="icon-btn" title="Mensajes" style="position:relative;">
        <i class="fas fa-envelope"></i>
      </button>
      <button class="icon-btn" title="Notificaciones" style="position:relative;">
        <i class="fas fa-bell"></i>
      </button>
      <div class="separador"></div>
      <div class="usuario-info">
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <span class="usuario-nombre">{{ Auth::user()->name }}</span>
        <span class="rol-badge {{ Auth::user()->rol }}">{{ ucfirst(Auth::user()->rol) }}</span>
      </div>
      <div class="separador"></div>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="icon-btn logout" title="Cerrar sesión">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </header>

  <!-- MAIN -->
  <main class="main">

    <div class="bienvenida-header">
      <div>
        <h1>Bienvenido, <span>{{ Auth::user()->name }}</span> 👋</h1>
        <p>
          @if(Auth::user()->rol === 'profesor')
            Aquí están tus materias asignadas.
          @else
            Aquí están tus materias inscritas.
          @endif
        </p>
      </div>
    </div>

    <!-- GRID DE MATERIAS -->
    @if($materias->isEmpty())
      <div class="campus-empty">
        <i class="fas fa-book-open"></i>
        <p>No tienes materias asignadas aún.</p>
        <span>Cuando se registren tus materias aparecerán aquí.</span>
      </div>
    @else
      <div class="materias-grid">
        @php
          $colores = [
            '#4f46e5','#0284c7','#059669','#d97706',
            '#dc2626','#7c3aed','#0891b2','#c2410c',
            '#16a34a','#9333ea'
          ];
        @endphp

        @foreach($materias as $i => $materia)
        <div class="tarjeta-materia">
          <div class="tarjeta-banner"
               style="background: {{ $colores[$i % count($colores)] }};">
            <span class="tarjeta-emoji">📚</span>
            @if(Auth::user()->rol === 'profesor')
              <span class="tarjeta-badge-prof">Profesor</span>
            @endif
          </div>
          <div class="tarjeta-body">
            <div class="tarjeta-codigo">{{ $materia->codigo }}</div>
            <div class="tarjeta-nombre">{{ $materia->nombre }}</div>
            <div class="tarjeta-meta">
              <span>
                <i class="fas fa-user-tie"></i>
                {{ $materia->profesor ? $materia->profesor->name : 'Sin profesor' }}
              </span>
              <span><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
              <span><i class="fas fa-door-open"></i> {{ $materia->salon }}</span>
            </div>
          </div>
          <div class="tarjeta-footer">
            <span class="tarjeta-creditos">
              <i class="fas fa-graduation-cap"></i>
              {{ $materia->creditos }} crédito{{ $materia->creditos !== 1 ? 's' : '' }}
            </span>
            <a href="{{ route('campus.materia', $materia->id) }}" class="btn-entrar">
              Entrar <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
        @endforeach

      </div>
    @endif

  </main>

</body>
</html>