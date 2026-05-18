<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Biblioteca Virtual — Campus UCC</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/timonel-nuevo.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/biblioteca.css') }}"/>
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="header-logo">
      <img src="{{ asset('logos/logo.png') }}" alt="UCC"/>
    </div>
    <div class="header-acciones">
      <div class="usuario-info">
        <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <span class="usuario-nombre">{{ Auth::user()->name }}</span>
        <span class="rol-badge {{ Auth::user()->rol }}">{{ ucfirst(Auth::user()->rol) }}</span>
      </div>
      <div class="separador"></div>
      <a href="{{ route('campus.index') }}"
        style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;
          background:#fff;color:var(--oscuro);border:1.5px solid var(--borde);
          border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Campus
      </a>
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

    <div class="pagina-header">
      <h1><i class="fas fa-book-reader" style="color:var(--primario);margin-right:10px;"></i>Biblioteca Virtual</h1>
      <p>Recursos académicos de acceso libre para toda la comunidad UCC.</p>
    </div>

    <!-- Buscador -->
    <div class="bib-busqueda">
      <div class="buscador-wrap" style="flex:1;">
        <i class="fas fa-search"></i>
        <input type="text" id="inputBusqueda"
          placeholder="Buscar por título, autor o categoría..."
          oninput="filtrarLibros()" style="width:100%;"/>
      </div>
    </div>

    <!-- Chips de categoría -->
    <div class="chips-categorias" id="chipsCategorias"></div>

    <!-- Grid de libros -->
    <div class="libros-grid" id="librosGrid"></div>

    <div id="vistaSinResultados" class="hidden">
      <div class="detalle-empty">
        <i class="fas fa-search"></i>
        <p>Sin resultados.</p>
        <span>Intenta con otro término o selecciona otra categoría.</span>
      </div>
    </div>

  </main>

  <!-- Footer derechos -->
  <footer class="bib-footer">
    <i class="fas fa-shield-alt"></i>
    Los libros disponibles son de dominio público o de acceso libre según sus licencias. Se respetan los derechos de autor.
    <span class="bib-footer-links">
      <a href="https://www.gutenberg.org" target="_blank">Project Gutenberg</a>
      <a href="https://openlibrary.org" target="_blank">Open Library</a>
      <a href="https://www.wdl.org" target="_blank">Biblioteca Digital Mundial</a>
    </span>
  </footer>

  <script>
  let categoriaActiva = 'Todos';

  const COLORES_CAT = {
    'Ingeniería': '#4f46e5', 'Matemáticas': '#0284c7',
    'Ciencias': '#059669',   'Literatura': '#d97706',
    'Historia': '#c2410c',   'Derecho': '#7c3aed',
    'Todos': '#64748b'
  };

  const CATEGORIAS = ['Todos','Ingeniería','Matemáticas','Ciencias','Literatura','Historia','Derecho'];

  const librosData = [
    { titulo: 'Cálculo Diferencial e Integral', autor: 'James Stewart', anio: 2016, categoria: 'Matemáticas', url: 'https://openlibrary.org' },
    { titulo: 'Introducción a la Programación', autor: 'Paul Deitel', anio: 2020, categoria: 'Ingeniería', url: 'https://openlibrary.org' },
    { titulo: 'Don Quijote de la Mancha', autor: 'Miguel de Cervantes', anio: 1605, categoria: 'Literatura', url: 'https://www.gutenberg.org/ebooks/2000' },
    { titulo: 'Física Universitaria', autor: 'Sears & Zemansky', anio: 2018, categoria: 'Ciencias', url: 'https://openlibrary.org' },
    { titulo: 'Historia de Colombia', autor: 'Marco Palacios', anio: 2010, categoria: 'Historia', url: 'https://openlibrary.org' },
    { titulo: 'Derecho Constitucional', autor: 'Eduardo García', anio: 2015, categoria: 'Derecho', url: 'https://openlibrary.org' },
    { titulo: 'Álgebra Lineal', autor: 'Gilbert Strang', anio: 2019, categoria: 'Matemáticas', url: 'https://openlibrary.org' },
    { titulo: 'Estructura de Datos', autor: 'Thomas Cormen', anio: 2022, categoria: 'Ingeniería', url: 'https://openlibrary.org' },
  ];

  function renderChips() {
    const wrap = document.getElementById('chipsCategorias');
    wrap.innerHTML = '';
    CATEGORIAS.forEach(cat => {
      const chip = document.createElement('button');
      chip.className = `chip-cat ${cat === categoriaActiva ? 'activo' : ''}`;
      chip.textContent = cat;
      chip.onclick = () => { categoriaActiva = cat; renderChips(); filtrarLibros(); };
      wrap.appendChild(chip);
    });
  }

  function filtrarLibros() {
    const q = document.getElementById('inputBusqueda').value.toLowerCase();
    let resultado = librosData;
    if (categoriaActiva !== 'Todos') resultado = resultado.filter(l => l.categoria === categoriaActiva);
    if (q) resultado = resultado.filter(l =>
      l.titulo.toLowerCase().includes(q) || l.autor.toLowerCase().includes(q) || l.categoria.toLowerCase().includes(q)
    );
    renderLibros(resultado);
  }

  function renderLibros(libros) {
    const grid = document.getElementById('librosGrid');
    const vacio = document.getElementById('vistaSinResultados');
    grid.innerHTML = '';
    if (!libros.length) { vacio.classList.remove('hidden'); return; }
    vacio.classList.add('hidden');
    libros.forEach((libro, i) => {
      const color = COLORES_CAT[libro.categoria] || '#64748b';
      grid.insertAdjacentHTML('beforeend', `
        <div class="libro-card" style="animation-delay:${i*0.04}s;">
          <div class="libro-portada" style="background:${color};">
            <span class="libro-portada-titulo">${libro.titulo}</span>
            <i class="fas fa-book libro-portada-icono"></i>
          </div>
          <div class="libro-body">
            <span class="libro-categoria" style="background:${color}22;color:${color};">${libro.categoria}</span>
            <div class="libro-titulo">${libro.titulo}</div>
            <div class="libro-autor"><i class="fas fa-user-pen"></i> ${libro.autor}</div>
            ${libro.anio ? `<div class="libro-anio"><i class="fas fa-calendar"></i> ${libro.anio}</div>` : ''}
          </div>
          <div class="libro-footer">
            <a href="${libro.url}" target="_blank" class="btn-leer">
              <i class="fas fa-book-open"></i> Leer en línea
            </a>
          </div>
        </div>
      `);
    });
  }

  renderChips();
  filtrarLibros();
  </script>

</body>
</html>
