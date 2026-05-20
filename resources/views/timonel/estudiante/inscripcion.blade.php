<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inscripción de Materias - Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/adminTimonel.css') }}"/>
  <style>
    .busqueda-wrapper {
      margin-bottom: 24px;
    }

    .input-busqueda {
      position: relative;
      max-width: 400px;
    }

    .input-busqueda i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 14px;
    }

    .input-busqueda input {
      width: 100%;
      padding: 11px 14px 11px 40px;
      border: 1.5px solid var(--borde);
      border-radius: 10px;
      font-size: 14px;
      font-family: inherit;
      color: var(--texto);
      background: #fff;
      outline: none;
      transition: border 0.2s;
    }

    .input-busqueda input:focus {
      border-color: var(--primario);
    }

    .materias-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
      margin-bottom: 100px;
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

    .materia-body {
      padding: 14px 18px;
    }

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

    .materia-meta i {
      color: var(--primario);
      width: 14px;
    }

    .btn-inscribir {
      width: 100%;
      padding: 9px;
      border: none;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: background 0.2s, transform 0.1s;
    }

    .btn-inscribir:hover {
      transform: translateY(-1px);
    }

    .btn-inscribir.no-inscrito {
      background: var(--primario);
      color: #fff;
    }

    .btn-inscribir.no-inscrito:hover {
      background: var(--primario-dark);
    }

    .btn-inscribir.inscrito {
      background: #d1fae5;
      color: #059669;
    }

    .btn-inscribir.inscrito:hover {
      background: #a7f3d0;
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

    .empty-state p {
      font-size: 15px;
      font-weight: 600;
    }

    .barra-inferior {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: var(--oscuro);
      color: #fff;
      padding: 14px 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      z-index: 50;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
      flex-wrap: wrap;
    }

    .barra-info {
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .barra-dato {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .barra-dato-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: rgba(255,255,255,0.5);
    }

    .barra-dato-valor {
      font-size: 18px;
      font-weight: 800;
      color: var(--primario);
    }

    .btn-factura {
      background: var(--primario);
      color: #fff;
      border: none;
      padding: 12px 24px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s, transform 0.1s, opacity 0.2s;
    }

    .btn-factura:hover:not(:disabled) {
      background: var(--primario-dark);
      transform: translateY(-1px);
    }

    .btn-factura:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }
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
        <span class="rol-badge" style="background:#e0f2fe; color:#0369a1;">Estudiante</span>
      </div>
      <form method="POST" action="{{ route('timonel.logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="icon-btn" title="Cerrar sesión">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </div>
  </header>

  <!-- Main -->
  <main class="main">

    <div class="pagina-header">
      <h1>Inscripción de Materias</h1>
      <p>Selecciona las materias en las que deseas inscribirte este semestre</p>
    </div>

    @if(session('success'))
      <p style="color:green; font-weight:600; margin-bottom:16px;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p style="color:red; font-weight:600; margin-bottom:16px;">{{ session('error') }}</p>
    @endif

    <!-- BARRA DE BÚSQUEDA -->
    <div class="busqueda-wrapper">
      <div class="input-busqueda">
        <i class="fas fa-search"></i>
        <input type="text" id="inputBusqueda"
               placeholder="Buscar por nombre o código..."
               oninput="filtrarMaterias()"/>
      </div>
    </div>

    <!-- GRID DE MATERIAS -->
    <div class="materias-grid" id="materiasGrid">

      @if($materias->isEmpty())
        <div class="empty-state">
          <i class="fas fa-calendar-times"></i>
          <p>No hay materias disponibles en este momento.</p>
        </div>
      @else
        @foreach($materias as $materia)
          @php $inscrito = in_array($materia->id, $inscritas); @endphp
          <div class="materia-card"
               data-nombre="{{ strtolower($materia->nombre) }}"
               data-codigo="{{ strtolower($materia->codigo) }}">
            <div class="materia-banner" style="background: linear-gradient(135deg, #00aaaa, #007f7f);">
              <span>📚</span>
            </div>
            <div class="materia-body">
              <p class="materia-codigo">{{ $materia->codigo }}</p>
              <p class="materia-nombre">{{ $materia->nombre }}</p>
              <div class="materia-meta">
                <span><i class="fas fa-user"></i> {{ $materia->profesor ? $materia->profesor->name : 'Sin profesor' }}</span>
                <span><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
                <span><i class="fas fa-map-marker-alt"></i> {{ $materia->salon }}</span>
                <span><i class="fas fa-star"></i> {{ $materia->creditos }} créditos</span>
              </div>

              @if($inscrito)
                <form method="POST" action="{{ route('timonel.inscripcion.destroy', $materia->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-inscribir inscrito">
                    <i class="fas fa-check"></i> Inscrito — Cancelar
                  </button>
                </form>
              @else
                <form method="POST" action="{{ route('timonel.inscripcion.store') }}">
                  @csrf
                  <input type="hidden" name="materia_id" value="{{ $materia->id }}"/>
                  <button type="submit" class="btn-inscribir no-inscrito">
                    <i class="fas fa-plus"></i> Inscribirse
                  </button>
                </form>
              @endif

            </div>
          </div>
        @endforeach
      @endif

    </div>
  </main>

  <!-- BARRA INFERIOR FIJA -->
  <div class="barra-inferior">
    <div class="barra-info">
      <div class="barra-dato">
        <span class="barra-dato-label">Materias inscritas</span>
        <span class="barra-dato-valor">{{ count($inscritas) }}</span>
      </div>
      <div class="barra-dato">
        <span class="barra-dato-label">Total de créditos</span>
        <span class="barra-dato-valor">
          {{ $materias->whereIn('id', $inscritas)->sum('creditos') }}
        </span>
      </div>
    </div>
    <form method="POST" action="{{ route('timonel.factura.store') }}">
      @csrf
      <button type="submit" class="btn-factura" {{ count($inscritas) === 0 ? 'disabled' : '' }}>
        <i class="fas fa-file-invoice"></i> Generar Factura
      </button>
    </form>
  </div>

  <script>
    function filtrarMaterias() {
      const texto = document.getElementById('inputBusqueda').value.toLowerCase();
      document.querySelectorAll('.materia-card').forEach(card => {
        const nombre = card.dataset.nombre || '';
        const codigo = card.dataset.codigo || '';
        card.style.display = (nombre.includes(texto) || codigo.includes(texto)) ? '' : 'none';
      });
    }
  </script>

</body>
</html>