<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Universidad Cooperativa de Colombia</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="header-izquierda">
      <button class="menu-btn" aria-label="Abrir menú">☰</button>
      <a href="#">
        <img class="logo-img" src="logos/logo.png" alt="Logo Universidad Cooperativa de Colombia"/>
      </a>
    </div>

    <nav class="nav-principal">
      <a href="https://www.ucc.edu.co/programas/Paginas/default.aspx">Oferta educativa</a>
      <a href="https://www.ucc.edu.co/aspirante">Aspirante</a>
      <a href="https://www.ucc.edu.co/estudiante">Estudiante</a>
      <a href="https://www.ucc.edu.co/profesor">Profes</a>
      <a href="https://www.ucc.edu.co/administrativo">Equipo administrativo</a>
    </nav>

    <nav class="nav-secundario">
      <a href="https://www.ucc.edu.co/egresado">Alumni</a>
      <a href="https://www.ucc.edu.co/empresa">Proveedores</a>
      <a href="https://www.comuna.com.co/index.php">Financiación</a>
    </nav>

  </header>


  <!-- Cuerpo -->
  <main>

    <!-- SECCIÓN 1: UCC EN CIFRAS -->
    <section class="cifras">
      <h2>UCC en cifras</h2>
      <p class="cifras-subtitulo">Creemos en el poder de la educación para transformar realidades.</p>

      <div class="cifras-grid">
        <div class="cifra-item">
          <span class="numero">127</span>
          <span class="etiqueta">Pregrados</span>
        </div>
        <div class="cifra-item">
          <span class="numero">152</span>
          <span class="etiqueta">Posgrados</span>
        </div>
        <div class="cifra-item">
          <span class="numero">51</span>
          <span class="etiqueta">Técnicas Laborales</span>
        </div>
        <div class="cifra-item">
          <span class="numero">36.636</span>
          <span class="etiqueta">Estudiantes</span>
        </div>
        <div class="cifra-item">
          <span class="numero">3.896</span>
          <span class="etiqueta">Profes</span>
        </div>
        <div class="cifra-item">
          <span class="numero">215.640</span>
          <span class="etiqueta">Alumni</span>
        </div>
        <div class="cifra-item">
          <span class="numero">15</span>
          <span class="etiqueta">Campus</span>
        </div>
      </div>

      <a href="https://www.ucc.edu.co/por-que-la-ucc" class="link-conoce">Conoce nuestra experiencia →</a>
    </section>


    <!-- SECCIÓN 2: INSTITUCIONAL -->
    <section class="institucional">
      <div class="institucional-texto">
        <span class="seccion-tag">INSTITUCIONAL</span>
        <h2>Conoce nuestro <strong>Modelo Educativo</strong></h2>
        <p>El modelo se enfoca en el desarrollo de competencias; lo hacemos a través de la pedagogía crítica, que es la manera como se concreta en lo educativo el ideal de la Teoría Crítica de educar para el mundo de la vida.</p>
        <a href="#" class="btn-ver">Ver más</a>
      </div>
      <div class="institucional-imagen">
        <img src="logos/imagenBody.jpg" alt="Modelo Educativo UCC"/>
      </div>
    </section>


    <!-- SECCIÓN 3: MEDIOS -->
    <section class="medios">
      <div class="medios-video">

        <img src="logos/colombia.jpeg"></img>
        <p class="medios-video-titulo">Colombia Nos Inspira - Universidad Cooperativa de Colombia</p>
      </div>

      <div class="medios-contenido">
        <span class="seccion-tag">MEDIOS</span>
        <h2>Vive la <strong>UCC</strong></h2>
        <p>En la UCC queremos crear lazos contigo para que juntos construyamos el futuro. Entérate de todo lo nuevo a través de nuestro canal de YouTube, ahora estamos más cerca que nunca.</p>

        <div class="medios-header">
          <h3>Últimos videos</h3>
          <a href="https://www.youtube.com/user/realizadorucc/featured" class="link-canal">Ver canal</a>
        </div>

        <!-- Miniaturas de videos -->
        <div class="videos-grid">
          <a href="https://www.youtube.com/watch?v=ChA2ITd7RNg" class="video-card">
            <img src="logos/balance.jpeg" alt="Balance Social 2023"/>
            <p>Balance Social 2023</p>
          </a>
          <a href="https://www.youtube.com/watch?v=YngSQ5qEF3c" class="video-card">
            <img src="logos/infraestructura.jpeg" alt="Infraestructura"/>
            <p>Infraestructura física y tecnológica para el aprendizaje</p>
          </a>
          <a href="https://www.youtube.com/watch?v=5NDUdv72OPs" class="video-card">
            <img src="logos/65años.jpeg" alt="65 años"/>
            <p>¡Estamos de fiesta, celebramos 65 años inspirados por Colombia!</p>
          </a>
        </div>
      </div>
    </section>


    <!-- SECCIÓN 4: CIENCIA ABIERTA -->
    <section class="ciencia">
      <h2>Ciencia Abierta</h2>
      <p class="ciencia-subtitulo">ESCOGE QUÉ TEMA PREFIERES</p>

      <div class="tarjetas-grid">

        <!-- Tarjeta 1 -->
        <div class="tarjeta">
          <div class="tarjeta-imagen">
            <img src="logos/Tarjeta1.jpg" alt="Omnicanalidad"/>
            <span class="tarjeta-tag">Investigación</span>
          </div>
          <div class="tarjeta-contenido">
            <h4>Omnicanalidad: estrategia, gestión y experiencia del consumidor</h4>
            <p>La omnicanalidad es más que una tendencia: es una capacidad estratégica.</p>
            <a href="https://www.ucc.edu.co/investigacion-sinfoni/sala-de-conocimiento/Paginas/Omnicanalidad-estrategia,-gesti%C3%B3n-y-experiencia-del-consumidor-en-Colombia.aspx" class="btn-tarjeta">Ver información →</a>
          </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="tarjeta">
          <div class="tarjeta-imagen">
            <img src="logos/Tarjeta2.jpg" alt="Semillero Psicología"/>
            <span class="tarjeta-tag">Investigación</span>
          </div>
          <div class="tarjeta-contenido">
            <h4>Semillero Desapsico de Psicología, contribuye a la prevención</h4>
            <p></p>
            <a href="https://www.ucc.edu.co/investigacion-sinfoni/sala-de-conocimiento/Paginas/Innovaci%C3%B3n-y-cuidado-el-nuevo-horizonte-de-la-Enfermer%C3%ADa.aspx" class="btn-tarjeta">Ver información →</a>
          </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="tarjeta">
          <div class="tarjeta-imagen">
            <img src="logos/Tarjeta3.jpg" alt="Inteligencia Artificial"/>
            <span class="tarjeta-tag">Investigación</span>
          </div>
          <div class="tarjeta-contenido">
            <h4>La Inteligencia Artificial como catalizador del Modelo Educativo</h4>
            <p>La IA no es una simple herramienta. Esta permite optimizar procesos de evaluación.</p>
            <a href="https://www.ucc.edu.co/investigacion-sinfoni/sala-de-conocimiento/Paginas/La-Inteligencia-Artificial-como-catalizador-del-Modelo-Educativo-Cr%C3%ADtico-con-Enfoque-de-Competencias-en-la-UCC.aspx" class="btn-tarjeta">Ver información →</a>
          </div>
        </div>

      </div>

      <a href="https://www.ucc.edu.co/investigacion-sinfoni/sala-de-conocimiento" class="link-conoce">Ver listado →</a>
    </section>

  </main>


  <!-- FOOTER -->
  <footer class="footer">

    <!-- Iconos de servicios con tooltip -->
    <div class="footer-iconos">
      <a href="#" class="tooltip">
        <img src="logos/logoBiblioteca.png" alt="Biblioteca"/>
        <span class="tooltip-texto">Ir a Biblioteca</span>
      </a>
      <a href="#" class="tooltip">
        <img src="logos/ediciones.png" alt="Ediciones UCC"/>
        <span class="tooltip-texto">Ir a Ediciones UCC</span>
      </a>
      <a href="#" class="tooltip">
        <img src="logos/Bienestar.png" alt="Bienestar"/>
        <span class="tooltip-texto">Ir a Bienestar</span>
      </a>
      <a href="{{ route('timonel.login') }}" class="tooltip">
        <img src="logos/Timonel.png" alt="Timonel"/>
        <span class="tooltip-texto">Ir a Timonel</span>
      </a>
      <a href="{{ route('login') }}" class="tooltip">
        <img src="logos/campus.png" alt="Campus Virtual"/>
        <span class="tooltip-texto">Ir a Campus Virtual</span>
      </a>
      <a href="#" class="tooltip">
        <img src="logos/servicios.png" alt="Servicios Digitales"/>
        <span class="tooltip-texto">Ir a Servicios Digitales</span>
      </a>
      <a href="#" class="tooltip">
        <img src="logos/data.png" />
        <span class="tooltip-texto">Habeas Data</span>
      </a>
    </div>

<!-- Redes sociales -->
<div class="footer-redes">
  <a href="https://www.instagram.com/ucc_oficial/" >
    <img src="logos/Instagram.png" />
  </a>
  <a href="https://www.youtube.com/channel/UCvzI0VYrgtpmloGmaqVEUbg" >
    <img src="logos/yt.png" />
  </a>
  <a href="https://x.com/UCooperativaCol" >
    <img src="logos/x.png" />
  </a>
  <a href="https://www.facebook.com/UCooperativadeColombia/" >
    <img src="logos/fb.png "/>
  </a>
  <a href="https://www.linkedin.com/school/universidad-cooperativa-de-colombia/" >
    <img src="logos/Linkedin.png" />
  </a>
</div>
  </footer>

</body>
</html>