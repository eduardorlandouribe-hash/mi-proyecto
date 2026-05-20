<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Financiero — Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/financiero.css') }}"/>
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
        <span class="rol-badge {{ $user->rol }}">
          {{ ucfirst($user->rol) }}
        </span>
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

  <!-- Main -->
  <main class="main">

    <div class="pagina-header">
      <h1>Financiero</h1>
      <p>Estado de tu matrícula</p>
    </div>

    @if($factura)

      <!-- Tarjeta resumen -->
      <div class="resumen-card">
        <div class="resumen-item">
          <span class="resumen-label">Total a pagar</span>
          <span class="resumen-valor">
            ${{ number_format($factura->total, 0, ',', '.') }}
          </span>
        </div>
        <div class="resumen-divider"></div>
        <div class="resumen-item">
          <span class="resumen-label">Estado</span>
          @if($factura->estado === 'pagada')
            <span class="estado-badge pagado">
              <i class="fas fa-check-circle"></i> Pagado
            </span>
          @else
            <span class="estado-badge pendiente">
              <i class="fas fa-clock"></i> Pendiente
            </span>
          @endif
        </div>
        <div class="resumen-divider"></div>
        <div class="resumen-item">
          <span class="resumen-label">Fecha de generación</span>
          <span class="resumen-valor normal">
            {{ $factura->created_at->format('d M Y') }}
          </span>
        </div>
        <div class="resumen-divider"></div>
        <div class="resumen-item">
          <span class="resumen-label">N° Factura</span>
          <span class="resumen-valor normal">{{ $factura->numero }}</span>
        </div>
      </div>

      <!-- Tabla de materias -->
      <div class="seccion-header">
        <h2>Materias inscritas</h2>
      </div>

      <div class="tabla-financiera-wrap">
        <table class="tabla-financiera">
          <thead>
            <tr>
              <th>Materia</th>
              <th>Código</th>
              <th style="text-align:center;">Créditos</th>
              <th style="text-align:right;">Valor / crédito</th>
              <th style="text-align:right;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
              <td style="font-weight:600;">{{ $inscripcion->materia->nombre }}</td>
              <td>
                <span style="font-size:11px;font-weight:700;padding:3px 10px;
                  border-radius:20px;background:rgba(0,170,170,0.1);color:#007f7f;">
                  {{ $inscripcion->materia->codigo }}
                </span>
              </td>
              <td style="text-align:center;">{{ $inscripcion->materia->creditos }}</td>
              <td style="text-align:right;color:var(--muted);">$150.000</td>
              <td style="text-align:right;font-weight:700;">
                ${{ number_format($inscripcion->materia->creditos * 150000, 0, ',', '.') }}
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="fila-total">
              <td colspan="2" style="color:var(--muted);font-size:13px;">
                {{ $inscripciones->count() }} materias en total
              </td>
              <td style="text-align:center;font-size:13px;color:var(--muted);">
                {{ $inscripciones->sum('materia.creditos') }}
              </td>
              <td style="text-align:right;font-size:13px;color:var(--muted);">Total</td>
              <td style="text-align:right;" class="total-valor">
                ${{ number_format($factura->total, 0, ',', '.') }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="acciones-bottom">
        <button class="btn-pdf" onclick="window.print()">
          <i class="fas fa-file-pdf"></i> Descargar PDF
        </button>
      </div>

    @else

      <!-- Empty state -->
      <div class="empty-state">
        <i class="fas fa-file-invoice-dollar"></i>
        <p>Aún no has generado una factura.</p>
        <span>Ve a <strong>Inscripción de Materias</strong> y genera tu factura para verla aquí.</span>
      </div>

    @endif

  </main>

</body>
</html>