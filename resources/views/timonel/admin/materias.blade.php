<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Materias - Timonel UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/adminTimonel.css') }}"/>
  <style>
    .btn-accion {
      border: none; border-radius: 8px; padding: 6px 12px;
      font-size: 12px; font-weight: 700; font-family: inherit;
      cursor: pointer; display: inline-flex; align-items: center;
      gap: 5px; transition: background 0.2s, transform 0.1s;
    }
    .btn-accion:hover { transform: translateY(-1px); }
    .btn-editar-fila { background: #e6f7f7; color: #007f7f; }
    .btn-editar-fila:hover { background: #ccf0f0; }
    .btn-eliminar-fila { background: #fee2e2; color: #ef4444; }
    .btn-eliminar-fila:hover { background: #fecaca; }
    .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
    .empty-state i { font-size: 48px; color: var(--borde); margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 15px; font-weight: 600; }
    .profesor-select { width: 100%; }
  </style>
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
        <span class="rol-badge">Administrador</span>
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
      <h1>Gestión de Materias</h1>
      <p>Crea, edita y administra todas las materias del sistema</p>
    </div>

    @if(session('success'))
      <p style="color:green; font-weight:600; margin-bottom:16px;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p style="color:red; font-weight:600; margin-bottom:16px;">{{ session('error') }}</p>
    @endif

    <div class="seccion-header">
      <h2>Materias registradas</h2>
      <button class="btn-crear" onclick="abrirModalCrear()">
        <i class="fas fa-plus"></i> Nueva Materia
      </button>
    </div>

    <div class="tabla-card">
      @if($materias->isEmpty())
        <div class="empty-state">
          <i class="fas fa-book-open"></i>
          <p>No hay materias creadas aún.</p>
        </div>
      @else
        <table class="tabla">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Créditos</th>
              <th>Horario</th>
              <th>Salón</th>
              <th>Profesor Asignado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($materias as $materia)
            <tr>
              <td>{{ $materia->codigo }}</td>
              <td>{{ $materia->nombre }}</td>
              <td>{{ $materia->creditos }}</td>
              <td>{{ $materia->horario }}</td>
              <td>{{ $materia->salon }}</td>
              <td>{{ $materia->profesor ? $materia->profesor->name : 'Sin asignar' }}</td>
              <td style="display:flex; gap:6px;">
                <button class="btn-accion btn-editar-fila"
                  onclick="abrirModalEditar(
                    {{ $materia->id }},
                    '{{ addslashes($materia->nombre) }}',
                    '{{ $materia->codigo }}',
                    {{ $materia->creditos }},
                    '{{ addslashes($materia->horario) }}',
                    '{{ addslashes($materia->salon) }}',
                    '{{ $materia->profesor_id ?? '' }}'
                  )">
                  <i class="fas fa-pen"></i> Editar
                </button>
                <form method="POST" action="{{ route('timonel.materias.destroy', $materia->id) }}"
                  onsubmit="return confirm('¿Eliminar esta materia?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-accion btn-eliminar-fila">
                    <i class="fas fa-trash"></i> Eliminar
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>

  </main>

  <!-- Modal (crear-editar) -->
  <div class="modal-overlay hidden" id="modalOverlay">
    <div class="modal">

      <div class="modal-header">
        <h3 id="modalTitulo">Nueva Materia</h3>
        <button type="button" onclick="cerrarModal()"><i class="fas fa-times"></i></button>
      </div>

      <form method="POST" id="formMateria" action="{{ route('timonel.materias.store') }}">
        @csrf
        <span id="methodField"></span>

        <div class="modal-body">

          <div class="campo-grupo">
            <label>Nombre de la Materia</label>
            <input type="text" name="nombre" id="mNombre" placeholder="Ej: Programación Web"/>
          </div>

          <div class="campo-fila">
            <div class="campo-grupo">
              <label>Código</label>
              <input type="text" name="codigo" id="mCodigo" placeholder="Ej: ISC-301"/>
            </div>
            <div class="campo-grupo">
              <label>Créditos</label>
              <input type="number" name="creditos" id="mCreditos" placeholder="3" min="1" max="10"/>
            </div>
          </div>

          <div class="campo-fila">
            <div class="campo-grupo">
              <label>Horario</label>
              <input type="text" name="horario" id="mHorario" placeholder="Ej: Lun-Mié 7:00am"/>
            </div>
            <div class="campo-grupo">
              <label>Salón</label>
              <input type="text" name="salon" id="mSalon" placeholder="Ej: Aula 204"/>
            </div>
          </div>

          <div class="campo-grupo">
            <label>Profesor Asignado</label>
            <select name="profesor_id" id="mProfesor" class="profesor-select">
              <option value="">-- Selecciona un profesor --</option>
              @foreach($profesores as $profesor)
                <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
          <button type="submit" class="btn-guardar">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>

      </form>
    </div>
  </div>

  <script>
    const baseUrl = "{{ url('timonel/materias') }}";

    function abrirModalCrear() {
      document.getElementById('modalTitulo').textContent = 'Nueva Materia';
      document.getElementById('formMateria').action = "{{ route('timonel.materias.store') }}";
      document.getElementById('methodField').innerHTML = '';
      document.getElementById('mNombre').value   = '';
      document.getElementById('mCodigo').value   = '';
      document.getElementById('mCreditos').value = '';
      document.getElementById('mHorario').value  = '';
      document.getElementById('mSalon').value    = '';
      document.getElementById('mProfesor').value = '';
      document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function abrirModalEditar(id, nombre, codigo, creditos, horario, salon, profesorId) {
      document.getElementById('modalTitulo').textContent = 'Editar Materia';
      document.getElementById('formMateria').action = baseUrl + '/' + id;
      document.getElementById('methodField').innerHTML =
        '<input type="hidden" name="_method" value="PATCH">';
      document.getElementById('mNombre').value   = nombre;
      document.getElementById('mCodigo').value   = codigo;
      document.getElementById('mCreditos').value = creditos;
      document.getElementById('mHorario').value  = horario;
      document.getElementById('mSalon').value    = salon;
      document.getElementById('mProfesor').value = profesorId;
      document.getElementById('modalOverlay').classList.remove('hidden');
    }

    function cerrarModal() {
      document.getElementById('modalOverlay').classList.add('hidden');
    }
  </script>

</body>
</html>