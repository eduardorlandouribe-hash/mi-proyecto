<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin - Timonel UCC</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/adminTimonel.css') }}">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-logo">
            <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
        </div>
        <div class="header-acciones">
            <div class="usuario-info">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
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

    <!-- MAIN -->
    <main class="main">

        <div class="pagina-header">
            <h1>Panel de Administrador</h1>
            <p>Gestiona materias y estudiantes</p>
        </div>

        <!-- TABS -->
        <div class="tabs">
            <button class="tab activo" onclick="mostrarTab('materias', this)">
                <i class="fas fa-book-open"></i> Materias
            </button>
            <button class="tab" onclick="mostrarTab('estudiantes', this)">
                <i class="fas fa-users"></i> Estudiantes
            </button>
            <button class="tab" onclick="mostrarTab('roles', this)">
                <i class="fas fa-user-shield"></i> Roles
            </button>
        </div>

        <!-- TAB: MATERIAS -->
        <div id="tabMaterias" class="tab-contenido">
            <div class="seccion-header">
                <h2>Materias disponibles</h2>
                <button class="btn-crear" onclick="abrirModal()">
                    <i class="fas fa-plus"></i> Nueva materia
                </button>
            </div>
            <div class="materias-grid" id="materiasGrid">
                <p class="cargando">Próximamente...</p>
            </div>
        </div>

        <!-- TAB: ESTUDIANTES -->
        <div id="tabEstudiantes" class="tab-contenido hidden">
            <div class="seccion-header">
                <h2>Usuarios registrados</h2>
            </div>
            <div class="tabla-card">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol actual</th>
                            <th>Cambiar rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->rol }}</td>
                            <td>
                                <form method="POST" action="{{ route('timonel.cambiarRol', $u->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="rol" onchange="this.form.submit()">
                                        <option value="estudiante" {{ $u->rol === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                        <option value="profesor" {{ $u->rol === 'profesor' ? 'selected' : '' }}>Profesor</option>
                                        <option value="admin" {{ $u->rol === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB: ROLES -->
        <div id="tabRoles" class="tab-contenido hidden">
            <div class="seccion-header">
                <h2>Gestión de roles</h2>
            </div>
            <p style="color: var(--muted)">Usa la pestaña Estudiantes para cambiar roles directamente. Próximamente más opciones.</p>
        </div>

    </main>

    <script>
    function mostrarTab(tab, btn) {
        document.querySelectorAll('.tab-contenido').forEach(t => t.classList.add('hidden'));
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('activo'));
        document.getElementById('tab' + tab.charAt(0).toUpperCase() + tab.slice(1)).classList.remove('hidden');
        btn.classList.add('activo');
    }
    </script>

</body>
</html>