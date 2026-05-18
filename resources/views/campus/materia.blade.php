<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Materia — Campus UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/materiaDetalle.css') }}"/>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="header-logo">
      <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
    </div>
    <div class="header-center">
      <span class="header-materia-nombre">{{ $materia->nombre }}</span>
    </div>
    <div class="header-acciones">
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

    <!-- Botón volver -->
    <div style="margin-bottom: 24px;">
      <a href="{{ route('campus.index') }}" style="display:inline-flex;align-items:center;gap:8px;
        padding:9px 18px;background:#fff;color:var(--oscuro);border:1.5px solid var(--borde);
        border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:all 0.2s;">
        <i class="fas fa-arrow-left"></i> Volver al Campus
      </a>
    </div>

    <!-- Banner de la materia -->
    @php
      $colores = ['#4f46e5','#0284c7','#059669','#d97706','#dc2626','#7c3aed'];
      $color = $colores[$materia->id % count($colores)];
    @endphp

    <div class="materia-banner-card" style="background: {{ $color }};">
      <span class="banner-emoji">📚</span>
      <div class="banner-info">
        <h1>{{ $materia->nombre }}</h1>
        <div class="banner-chips">
          <span class="chip"><i class="fas fa-tag"></i> {{ $materia->codigo }}</span>
          <span class="chip"><i class="fas fa-user-tie"></i> {{ $materia->profesor ? $materia->profesor->name : 'Sin profesor' }}</span>
          <span class="chip"><i class="fas fa-clock"></i> {{ $materia->horario }}</span>
          <span class="chip"><i class="fas fa-door-open"></i> {{ $materia->salon }}</span>
          <span class="chip"><i class="fas fa-graduation-cap"></i> {{ $materia->creditos }} créditos</span>
        </div>
      </div>
    </div>

    @if(session('success'))
      <p style="color:green;font-weight:600;margin:16px 0;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p style="color:red;font-weight:600;margin:16px 0;">{{ session('error') }}</p>
    @endif

    <!-- ══════════ MATERIALES ══════════ -->
    <div class="seccion-header" style="margin-top:32px;">
      <h2><i class="fas fa-folder-open" style="color:var(--primario);margin-right:8px;"></i>Materiales</h2>
      @if(Auth::user()->rol === 'profesor' || Auth::user()->rol === 'admin')
        <button class="btn-crear" onclick="document.getElementById('modalMaterial').classList.remove('hidden')">
          <i class="fas fa-plus"></i> Subir material
        </button>
      @endif
    </div>

    @if($materia->materiales->isEmpty())
      <div class="detalle-empty" style="margin-bottom:32px;">
        <i class="fas fa-folder-open"></i>
        <p>No hay materiales aún.</p>
        <span>El profesor subirá los recursos aquí.</span>
      </div>
    @else
      @foreach($materia->materiales as $material)
      <div class="material-item">
        <div class="material-icono">
          @if($material->tipo === 'pdf') 📄
          @elseif($material->tipo === 'link') 🔗
          @else 🖼️
          @endif
        </div>
        <div class="material-info">
          <span class="material-nombre">{{ $material->nombre }}</span>
          <span class="material-meta">
            <span class="material-tipo">{{ strtoupper($material->tipo) }}</span>
          </span>
        </div>
        <div class="material-acciones" style="display:flex;gap:8px;">
          <a href="{{ $material->url }}" target="_blank" class="btn-material-accion">
            <i class="fas fa-external-link-alt"></i> Abrir
          </a>
          @if(Auth::user()->rol === 'profesor' || Auth::user()->rol === 'admin')
            <form method="POST" action="{{ route('campus.materiales.destroy', $material->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-material-accion"
                style="color:#ef4444;border-color:#fecaca;"
                onsubmit="return confirm('¿Eliminar material?')">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          @endif
        </div>
      </div>
      @endforeach
    @endif

    <!-- ══════════ TAREAS ══════════ -->
    <div class="seccion-header" style="margin-top:32px;">
      <h2><i class="fas fa-tasks" style="color:var(--primario);margin-right:8px;"></i>Tareas</h2>
      @if(Auth::user()->rol === 'profesor' || Auth::user()->rol === 'admin')
        <button class="btn-crear" onclick="document.getElementById('modalTarea').classList.remove('hidden')">
          <i class="fas fa-plus"></i> Nueva tarea
        </button>
      @endif
    </div>

    @if($materia->tareas->isEmpty())
      <div class="detalle-empty">
        <i class="fas fa-tasks"></i>
        <p>No hay tareas aún.</p>
        <span>El profesor publicará las tareas aquí.</span>
      </div>
    @else
      <div class="tareas-grid">
        @foreach($materia->tareas as $tarea)
          @php
            $estadoEntrega = $entregas[$tarea->id] ?? 'pendiente';
            $vencida = now()->gt($tarea->fecha_limite) && $estadoEntrega === 'pendiente';
            if($vencida) $estadoEntrega = 'vencida';
          @endphp
          <div class="tarea-card">
            <div class="tarea-card-header">
              @if(Auth::user()->rol === 'estudiante')
                <span class="tarea-estado-badge {{ $estadoEntrega }}">
                  @if($estadoEntrega === 'entregada') <i class="fas fa-check"></i> Entregada
                  @elseif($estadoEntrega === 'vencida') <i class="fas fa-times"></i> Vencida
                  @else <i class="fas fa-clock"></i> Pendiente
                  @endif
                </span>
              @endif
            </div>
            <div class="tarea-titulo">{{ $tarea->titulo }}</div>
            @if($tarea->descripcion)
              <div class="tarea-desc">{{ $tarea->descripcion }}</div>
            @endif
            <div class="tarea-fecha {{ $vencida ? 'fecha-vencida' : '' }}">
              <i class="fas fa-calendar-alt"></i>
              Entrega: {{ $tarea->fecha_limite->format('d M Y, h:i a') }}
            </div>
            <div class="tarea-footer" style="display:flex;gap:8px;justify-content:flex-end;">
              @if(Auth::user()->rol === 'estudiante' && $estadoEntrega === 'pendiente')
                <button class="btn-tarea-entregar"
                  onclick="document.getElementById('modalEntrega{{ $tarea->id }}').classList.remove('hidden')">
                  <i class="fas fa-upload"></i> Entregar
                </button>
              @endif
              @if(Auth::user()->rol === 'profesor' || Auth::user()->rol === 'admin')
                <a href="{{ route('campus.entregas.index', $tarea->id) }}" class="btn-tarea-entregas">
                  <i class="fas fa-users"></i> Ver entregas
                </a>
                <form method="POST" action="{{ route('campus.tareas.destroy', $tarea->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-tarea-entregas"
                    style="color:#ef4444;border-color:#fecaca;"
                    onclick="return confirm('¿Eliminar tarea?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              @endif
            </div>
          </div>

          <!-- Modal entrega por tarea -->
          @if(Auth::user()->rol === 'estudiante')
          <div class="modal-overlay hidden" id="modalEntrega{{ $tarea->id }}">
            <div class="modal">
              <div class="modal-header">
                <h3>Entregar: {{ $tarea->titulo }}</h3>
                <button type="button" onclick="document.getElementById('modalEntrega{{ $tarea->id }}').classList.add('hidden')">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <form method="POST" action="{{ route('campus.entregas.store') }}">
                @csrf
                <input type="hidden" name="tarea_id" value="{{ $tarea->id }}"/>
                <div class="modal-body">
                  <div class="campo-grupo">
                    <label>Comentario o link de entrega</label>
                    <textarea name="comentario" rows="4"
                      style="width:100%;padding:10px 14px;border:1.5px solid var(--borde);
                        border-radius:10px;font-size:14px;font-family:inherit;resize:vertical;"
                      placeholder="Escribe tu comentario o pega el link de tu entrega..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn-cancelar"
                    onclick="document.getElementById('modalEntrega{{ $tarea->id }}').classList.add('hidden')">
                    Cancelar
                  </button>
                  <button type="submit" class="btn-guardar">
                    <i class="fas fa-paper-plane"></i> Enviar entrega
                  </button>
                </div>
              </form>
            </div>
          </div>
          @endif

        @endforeach
      </div>
    @endif

  </main>

  <!-- Modal subir material -->
  @if(Auth::user()->rol === 'profesor' || Auth::user()->rol === 'admin')
  <div class="modal-overlay hidden" id="modalMaterial">
    <div class="modal">
      <div class="modal-header">
        <h3>Subir Material</h3>
        <button type="button" onclick="document.getElementById('modalMaterial').classList.add('hidden')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form method="POST" action="{{ route('campus.materiales.store') }}">
        @csrf
        <input type="hidden" name="materia_id" value="{{ $materia->id }}"/>
        <div class="modal-body">
          <div class="campo-grupo">
            <label>Nombre del material</label>
            <input type="text" name="nombre" placeholder="Ej: Guía de estudio semana 1"/>
          </div>
          <div class="campo-grupo">
            <label>Tipo</label>
            <select name="tipo">
              <option value="pdf">PDF</option>
              <option value="link">Link</option>
              <option value="imagen">Imagen</option>
            </select>
          </div>
          <div class="campo-grupo">
            <label>URL del material</label>
            <input type="text" name="url" placeholder="https://..."/>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancelar"
            onclick="document.getElementById('modalMaterial').classList.add('hidden')">
            Cancelar
          </button>
          <button type="submit" class="btn-guardar">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal crear tarea -->
  <div class="modal-overlay hidden" id="modalTarea">
    <div class="modal">
      <div class="modal-header">
        <h3>Nueva Tarea</h3>
        <button type="button" onclick="document.getElementById('modalTarea').classList.add('hidden')">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form method="POST" action="{{ route('campus.tareas.store') }}">
        @csrf
        <input type="hidden" name="materia_id" value="{{ $materia->id }}"/>
        <div class="modal-body">
          <div class="campo-grupo">
            <label>Título de la tarea</label>
            <input type="text" name="titulo" placeholder="Ej: Taller 1 - Introducción"/>
          </div>
          <div class="campo-grupo">
            <label>Descripción</label>
            <textarea name="descripcion" rows="3"
              style="width:100%;padding:10px 14px;border:1.5px solid var(--borde);
                border-radius:10px;font-size:14px;font-family:inherit;resize:vertical;"
              placeholder="Instrucciones de la tarea..."></textarea>
          </div>
          <div class="campo-grupo">
            <label>Fecha límite</label>
            <input type="datetime-local" name="fecha_limite"/>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancelar"
            onclick="document.getElementById('modalTarea').classList.add('hidden')">
            Cancelar
          </button>
          <button type="submit" class="btn-guardar">
            <i class="fas fa-save"></i> Crear tarea
          </button>
        </div>
      </form>
    </div>
  </div>
  @endif

</body>
</html>
