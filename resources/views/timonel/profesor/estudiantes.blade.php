<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Estudiantes Inscritos - Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/adminTimonel.css') }}"/>
  <style>
    .btn-volver {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 9px 18px;
      background: var(--gris-bg);
      color: var(--oscuro);
      border: 1.5px solid var(--borde);
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      font-family: inherit;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-volver:hover {
      background: var(--primario);
      color: #fff;
      border-color: var(--primario);
    }

    .info-materia-card {
      background: #fff;
      border-radius: 14px;
      border: 1.5px solid var(--borde);
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 28px;
      overflow: hidden;
    }

    .info-banner {
      width: 90px;
      min-height: 90px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 26px;
    }

    .info-datos {
      padding: 16px 0;
      flex: 1;
    }

    .info-datos h2 {
      font-size: 18px;
      font-weight: 800;
      color: var(--oscuro);
      margin-bottom: 6px;
    }

    .info-chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-top: 8px;
    }

    .chip {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: var(--gris-bg);
      color: var(--muted);
      font-size: 12px;
      font-weight: 600;
      padding: 4px 12px;
      border-radius: 20px;
      border: 1px solid var(--borde);
    }
    .chip i { color: var(--primario); }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
    }

    .badge.creditos {
      background: #e0f2fe;
      color: #0369a1;
    }

    .badge.pendiente {
      background: #fef3c7;
      color: #d97706;
    }

    .badge.pagado {
      background: #d1fae5;
      color: #059669;
    }

    .total-chip {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0 24px;
      gap: 4px;
      border-left: 1px solid var(--borde);
      min-width: 110px;
    }

    .total-chip i {
      font-size: 22px;
      color: var(--primario);
    }

    .total-chip span {
      font-size: 13px;
      font-weight: 700;
      color: var(--oscuro);
      text-align: center;
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
    }
    .empty-state i {
      font-size: 48px;
      color: var(--borde);
      margin-bottom: 16px;
      display: block;
    }
    .empty-state p { font-size: 15px; font-weight: 600; }
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

    <!-- BOTÓN VOLVER -->
    <div style="margin-bottom: 24px;">
      <a href="{{ route('timonel.profesor.index') }}" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver a mis materias
      </a>
    </div>

    <!-- INFO DE LA MATERIA -->
    <div class="info-materia-card">
      <div class="info-banner" style="background: linear-gradient(135deg, #00aaaa, #007f7f);">
        <span>📚</span>
      </div>
      <div class="info-datos">
        <h2>{{ $materia->nombre }}</h2>
        <span class="badge creditos">{{ $materia->codigo }}</span>
        <div class="info-chips">
          <span class="chip"><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
          <span class="chip"><i class="fas fa-map-marker-alt"></i> {{ $materia->salon }}</span>
          <span class="chip"><i class="fas fa-star"></i> {{ $materia->creditos }} créditos</span>
        </div>
      </div>
      <div class="total-chip">
        <i class="fas fa-users"></i>
        <span>{{ $estudiantes->count() }} estudiantes</span>
      </div>
    </div>

    <!-- TABLA ESTUDIANTES -->
    <div class="seccion-header">
      <h2>Lista de estudiantes inscritos</h2>
    </div>

    <div class="tabla-card">
      @if($estudiantes->isEmpty())
        <div class="empty-state">
          <i class="fas fa-users"></i>
          <p>Aún no hay estudiantes inscritos en esta materia.</p>
        </div>
      @else
        <table class="tabla">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre completo</th>
              <th>Correo electrónico</th>
              <th>Fecha de inscripción</th>
              <th>Estado de pago</th>
            </tr>
          </thead>
          <tbody>
            @foreach($estudiantes as $index => $inscripcion)
            <tr>
              <td style="color:var(--muted); font-weight:700;">
                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
              </td>
              <td style="font-weight:700;">{{ $inscripcion->estudiante->name }}</td>
              <td style="color:var(--muted);">{{ $inscripcion->estudiante->email }}</td>
              <td>{{ $inscripcion->created_at->format('d M Y') }}</td>
              <td>
                @php
                  $factura = $inscripcion->estudiante->facturas->first();
                @endphp
                @if($factura && $factura->estado === 'pagada')
                  <span class="badge pagado">
                    <i class="fas fa-check-circle"></i> Pagado
                  </span>
                @else
                  <span class="badge pendiente">
                    <i class="fas fa-clock"></i> Pendiente
                  </span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </main>

</body>
</html>