<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Panel Profesor - Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/adminTimonel.css') }}"/>
  <style>
    .bienvenida {
      display: flex;
      align-items: center;
      gap: 18px;
      margin-bottom: 32px;
    }

    .avatar-profesor {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--oscuro), var(--primario));
      color: #fff;
      font-size: 22px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 16px rgba(0,170,170,0.3);
    }

    .bienvenida-texto h1 {
      font-size: 24px;
      font-weight: 800;
      color: var(--oscuro);
      margin-bottom: 4px;
    }

    .bienvenida-texto p {
      font-size: 14px;
      color: var(--muted);
    }

    .materias-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
    }

    .materia-card {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      border: 1.5px solid var(--borde);
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      animation: fadeUp 0.3s ease both;
      transition: box-shadow 0.2s, transform 0.2s;
    }
    .materia-card:hover {
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .materia-banner {
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 18px;
      font-size: 28px;
    }

    .materia-tipo {
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      background: rgba(255,255,255,0.25);
      color: #fff;
    }

    .materia-body { padding: 14px 18px; }

    .materia-codigo {
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .materia-nombre {
      font-size: 14px;
      font-weight: 700;
      color: var(--oscuro);
      margin-bottom: 10px;
      line-height: 1.4;
    }

    .materia-meta {
      font-size: 12px;
      color: var(--muted);
      display: flex;
      flex-direction: column;
      gap: 4px;
      margin-bottom: 14px;
    }
    .materia-meta span {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .materia-meta i { color: var(--primario); width: 14px; }

    .btn-ver-estudiantes {
      width: 100%;
      padding: 9px;
      background: var(--gris-bg);
      color: var(--oscuro);
      border: 1.5px solid var(--borde);
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.2s;
      text-decoration: none;
    }
    .btn-ver-estudiantes:hover {
      background: var(--primario);
      color: #fff;
      border-color: var(--primario);
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
      grid-column: 1 / -1;
    }
    .empty-state i {
      font-size: 48px;
      color: var(--borde);
      margin-bottom: 16px;
      display: block;
    }
    .empty-state p { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
    .empty-state small { font-size: 13px; }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="header-logo">
      <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
    </div>
    <div class="header-acciones">
      <div class="usuario-info">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <span class="usuario-nombre">{{ $user->name }}</span>
        <span class="rol-badge" style="background:#f0fdf4; color:#16a34a;">Profesor</span>
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

    <!-- SALUDO -->
    <div class="bienvenida">
      <div class="avatar-profesor">
        {{ strtoupper(substr($user->name, 0, 2)) }}
      </div>
      <div class="bienvenida-texto">
        <h1>Hola, {{ $user->name }} 👋</h1>
        <p>Estas son tus materias asignadas para este semestre.</p>
      </div>
    </div>

    <!-- GRID DE MATERIAS -->
    <div class="materias-grid">

      @if($materias->isEmpty())
        <div class="empty-state">
          <i class="fas fa-chalkboard-teacher"></i>
          <p>No tienes materias asignadas aún.</p>
          <small>Contacta al administrador.</small>
        </div>
      @else
        @foreach($materias as $materia)
        <div class="materia-card">
          <div class="materia-banner" style="background: linear-gradient(135deg, #00aaaa, #007f7f);">
            <span>📚</span>
            <span class="materia-tipo">{{ $materia->creditos }} créditos</span>
          </div>
          <div class="materia-body">
            <p class="materia-codigo">{{ $materia->codigo }}</p>
            <p class="materia-nombre">{{ $materia->nombre }}</p>
            <div class="materia-meta">
              <span><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
              <span><i class="fas fa-map-marker-alt"></i> {{ $materia->salon }}</span>
              <span>
                <i class="fas fa-users"></i>
                {{ $materia->inscripciones->count() }} estudiantes inscritos
              </span>
            </div>
            <a href="{{ route('timonel.profesor.estudiantes', $materia->id) }}"
               class="btn-ver-estudiantes">
              <i class="fas fa-users"></i> Ver estudiantes
            </a>
          </div>
        </div>
        @endforeach
      @endif

    </div>

  </main>

</body>
</html>