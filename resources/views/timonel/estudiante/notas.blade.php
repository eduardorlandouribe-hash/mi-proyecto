<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mis Notas — Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/notas.css') }}"/>
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
  <main class="main">

    <div class="pagina-header">
      <h1>Mis Notas</h1>
      <p>Calificaciones por materia y semestre.</p>
    </div>

    @if($notas->isEmpty())

      <!-- Empty state -->
      <div class="empty-state">
        <i class="fas fa-chart-bar"></i>
        <p>Aún no tienes calificaciones registradas.</p>
        <span>Cuando el profesor ingrese tus notas aparecerán aquí.</span>
      </div>

    @else

      <!-- Tarjeta promedio general -->
      @php
        $definitivas = $notas->map(function($n) {
          $vals = collect([$n->nota1, $n->nota2, $n->nota3])->filter();
          return $vals->count() ? $vals->avg() : null;
        })->filter();

        $promedio    = $definitivas->count() ? round($definitivas->avg(), 2) : null;
        $aprobadas   = $definitivas->filter(fn($d) => $d >= 3.0)->count();
        $reprobadas  = $definitivas->filter(fn($d) => $d < 3.0)->count();
        $creditos    = $notas->sum('materia.creditos');
      @endphp

      <div class="promedio-card">
        <div>
          <div class="promedio-numero">{{ $promedio ?? '—' }}</div>
          <div class="promedio-label">Promedio general</div>
        </div>
        <div class="promedio-divider"></div>
        <div class="promedio-info">
          <span class="promedio-label">Rendimiento</span>
          @if($promedio)
            @if($promedio >= 3.5)
              <span class="promedio-badge alto"><i class="fas fa-check"></i> Buen rendimiento</span>
            @elseif($promedio >= 3.0)
              <span class="promedio-badge medio"><i class="fas fa-exclamation"></i> Rendimiento regular</span>
            @else
              <span class="promedio-badge bajo"><i class="fas fa-times"></i> Rendimiento bajo</span>
            @endif
          @endif
        </div>
        <div class="promedio-divider"></div>
        <div class="promedio-stats">
          <div class="promedio-stat">
            <span class="valor">{{ $aprobadas }}</span>
            <span class="etiqueta">Materias aprobadas</span>
          </div>
          <div class="promedio-stat">
            <span class="valor">{{ $reprobadas }}</span>
            <span class="etiqueta">Materias reprobadas</span>
          </div>
          <div class="promedio-stat">
            <span class="valor">{{ $creditos }}</span>
            <span class="etiqueta">Créditos cursados</span>
          </div>
        </div>
      </div>

      <!-- Tabla de notas -->
      <div class="seccion-header">
        <h2>Calificaciones por materia</h2>
      </div>

      <div class="tabla-notas-wrap">
        <table class="tabla-notas">
          <thead>
            <tr>
              <th>Materia</th>
              <th>Código</th>
              <th class="center">Créditos</th>
              <th class="center">Nota 1</th>
              <th class="center">Nota 2</th>
              <th class="center">Nota 3</th>
              <th class="center">Definitiva</th>
            </tr>
          </thead>
          <tbody>
            @foreach($notas as $nota)
              @php
                $vals = collect([$nota->nota1, $nota->nota2, $nota->nota3])->filter();
                $def  = $vals->count() ? round($vals->avg(), 2) : null;
                $aprueba = $def !== null && $def >= 3.0;
              @endphp
              <tr>
                <td style="font-weight:600;">{{ $nota->materia->nombre }}</td>
                <td><span class="codigo-badge">{{ $nota->materia->codigo }}</span></td>
                <td class="center">{{ $nota->materia->creditos }}</td>
                <td class="center">
                  <span class="nota-valor {{ !$nota->nota1 ? 'vacia' : '' }}">
                    {{ $nota->nota1 ? number_format($nota->nota1, 1) : '—' }}
                  </span>
                </td>
                <td class="center">
                  <span class="nota-valor {{ !$nota->nota2 ? 'vacia' : '' }}">
                    {{ $nota->nota2 ? number_format($nota->nota2, 1) : '—' }}
                  </span>
                </td>
                <td class="center">
                  <span class="nota-valor {{ !$nota->nota3 ? 'vacia' : '' }}">
                    {{ $nota->nota3 ? number_format($nota->nota3, 1) : '—' }}
                  </span>
                </td>
                <td class="center">
                  @if($def !== null)
                    <span class="nota-definitiva {{ $aprueba ? 'aprobada' : 'reprobada' }}">
                      {{ number_format($def, 1) }}
                    </span>
                  @else
                    <span class="nota-definitiva" style="color:var(--borde);">—</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    @endif

  </main>

</body>
</html>