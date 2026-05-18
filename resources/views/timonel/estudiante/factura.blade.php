<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Factura de Inscripción - Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    :root {
      --primario: #00aaaa;
      --primario-dark: #007f7f;
      --oscuro: #1a1a2e;
      --gris-bg: #f0f4f8;
      --texto: #1e293b;
      --muted: #64748b;
      --borde: #e2e8f0;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--gris-bg);
      color: var(--texto);
      min-height: 100vh;
    }

    .header-factura {
      background: #fff;
      border-bottom: 3px solid var(--primario);
      height: 68px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 12px rgba(0,170,170,0.08);
    }
    .header-factura img { height: 46px; object-fit: contain; }

    .main {
      max-width: 760px;
      margin: 0 auto;
      padding: 40px 32px;
    }

    .factura-doc {
      background: #fff;
      border-radius: 16px;
      border: 1.5px solid var(--borde);
      box-shadow: 0 4px 20px rgba(0,0,0,0.07);
      overflow: hidden;
      animation: fadeUp 0.4s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .factura-header {
      background: var(--oscuro);
      padding: 28px 36px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .factura-titulo { color: #fff; }
    .factura-titulo h1 {
      font-size: 22px;
      font-weight: 800;
      margin-bottom: 4px;
    }
    .factura-titulo p {
      font-size: 13px;
      color: rgba(255,255,255,0.6);
    }

    .factura-numero { text-align: right; }
    .factura-numero-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: rgba(255,255,255,0.5);
      margin-bottom: 4px;
    }
    .factura-numero-valor {
      font-size: 20px;
      font-weight: 800;
      color: var(--primario);
    }

    .factura-body { padding: 28px 36px; }

    .seccion-titulo {
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .seccion-titulo i { color: var(--primario); }

    .estudiante-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 14px;
      margin-bottom: 28px;
    }

    .dato-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .dato-label {
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .dato-valor {
      font-size: 14px;
      font-weight: 600;
      color: var(--texto);
    }

    .divider {
      height: 1px;
      background: var(--borde);
      margin: 24px 0;
    }

    .tabla-materias {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 0;
    }
    .tabla-materias thead { background: var(--gris-bg); }
    .tabla-materias th {
      padding: 11px 16px;
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: left;
      border-bottom: 1px solid var(--borde);
    }
    .tabla-materias td {
      padding: 13px 16px;
      font-size: 14px;
      color: var(--texto);
      border-bottom: 1px solid var(--borde);
    }
    .tabla-materias tbody tr:last-child td { border-bottom: none; }
    .tabla-materias tbody tr:hover { background: #fafafa; }

    .fila-total { background: var(--gris-bg) !important; }
    .fila-total td {
      font-weight: 800 !important;
      font-size: 15px !important;
      color: var(--oscuro) !important;
      border-top: 2px solid var(--borde) !important;
    }
    .fila-total .total-valor {
      color: var(--primario) !important;
      font-size: 18px !important;
    }

    .estado-pago-wrapper {
      display: flex;
      justify-content: flex-end;
      padding: 20px 36px;
      border-top: 1px solid var(--borde);
      background: #fffbeb;
    }
    .estado-pago-badge {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #fef3c7;
      color: #d97706;
      font-size: 13px;
      font-weight: 700;
      padding: 8px 20px;
      border-radius: 30px;
      border: 1.5px solid #fde68a;
    }
    .estado-pago-badge i { font-size: 14px; }

    .factura-acciones {
      display: flex;
      gap: 12px;
      justify-content: flex-end;
      flex-wrap: wrap;
      margin-top: 28px;
    }

    .btn-secundario {
      padding: 11px 22px;
      border-radius: 10px;
      border: 1.5px solid var(--borde);
      background: var(--gris-bg);
      color: var(--muted);
      font-size: 14px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
      text-decoration: none;
    }
    .btn-secundario:hover { background: #e2e8f0; color: var(--texto); }

    .btn-primario {
      padding: 11px 22px;
      border-radius: 10px;
      border: none;
      background: var(--primario);
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s, transform 0.1s;
    }
    .btn-primario:hover {
      background: var(--primario-dark);
      transform: translateY(-1px);
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="header-factura">
    <img src="{{ asset('logos/logo.png') }}" alt="Universidad Cooperativa de Colombia"/>
  </header>

  <!-- MAIN -->
  <main class="main">

    <div class="factura-doc">

      <!-- Cabecera -->
      <div class="factura-header">
        <div class="factura-titulo">
          <h1>Factura de Inscripción</h1>
          <p>Universidad Cooperativa de Colombia — Timonel</p>
        </div>
        <div class="factura-numero">
          <div class="factura-numero-label">N° de Factura</div>
          <div class="factura-numero-valor">{{ $factura->numero }}</div>
        </div>
      </div>

      <!-- Cuerpo -->
      <div class="factura-body">

        <!-- Info del estudiante -->
        <div class="seccion-titulo">
          <i class="fas fa-user"></i> Información del Estudiante
        </div>

        <div class="estudiante-grid">
          <div class="dato-item">
            <span class="dato-label">Nombre completo</span>
            <span class="dato-valor">{{ $user->name }}</span>
          </div>
          <div class="dato-item">
            <span class="dato-label">Correo electrónico</span>
            <span class="dato-valor">{{ $user->email }}</span>
          </div>
          <div class="dato-item">
            <span class="dato-label">Fecha de generación</span>
            <span class="dato-valor">{{ $factura->created_at->format('d M Y') }}</span>
          </div>
        </div>

        <div class="divider"></div>

        <!-- Tabla de materias -->
        <div class="seccion-titulo" style="margin-bottom: 16px;">
          <i class="fas fa-book-open"></i> Materias Inscritas
        </div>

        <table class="tabla-materias">
          <thead>
            <tr>
              <th>Materia</th>
              <th>Código</th>
              <th>Créditos</th>
              <th>Valor / Crédito</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inscripciones as $inscripcion)
            <tr>
              <td>{{ $inscripcion->materia->nombre }}</td>
              <td>{{ $inscripcion->materia->codigo }}</td>
              <td>{{ $inscripcion->materia->creditos }}</td>
              <td>$150.000</td>
              <td>${{ number_format($inscripcion->materia->creditos * 150000, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="fila-total">
              <td colspan="4" style="text-align:right;">Total a Pagar</td>
              <td class="total-valor">${{ number_format($factura->total, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>

      </div>

      <!-- Estado de pago -->
      <div class="estado-pago-wrapper">
        <div class="estado-pago-badge">
          <i class="fas fa-clock"></i> Pendiente de pago
        </div>
      </div>

    </div>

    <!-- BOTONES -->
    <div class="factura-acciones">
      <a href="{{ route('timonel.inscripcion.index') }}" class="btn-secundario">
        <i class="fas fa-arrow-left"></i> Volver a inscripción
      </a>
      <button class="btn-primario" onclick="window.print()">
        <i class="fas fa-download"></i> Descargar PDF
      </button>
    </div>

  </main>

</body>
</html>