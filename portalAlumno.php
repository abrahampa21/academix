<?php
  include("conexion.php");
  if (!isset($_SESSION['matriculaA'])) {
    echo "<script>alert('Por favor, inicie sesión primero'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="src/academix.jpg" />
    <link rel="stylesheet" href="portalAlumno/portales.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"
    />
    <script
      src="https://kit.fontawesome.com/e522357059.js"
      crossorigin="anonymous"
    ></script>
    <title>Portal del Alumno</title>
  </head>
  <body>
    <header>
      <nav class="nav-bar">
        <div class="title">
          <img
            src="src/academix.jpg"
            class="logo"
            alt="Logo"
            draggable="false"
          />
          <h1>ACADEMIX</h1>
        </div>
        <div class="toggle" id="toggle">
          <i class="fa-solid fa-bars" id="bars"></i>
        </div>
        <ul class="links">
          <li><a href="#about-us" title="menu">Sobre Nosotros</a></li>
          <li><a href="#focus" title="menu">Enfoque</a></li>
          <li><a href="#contacto" title="menu">Contacto</a></li>
        </ul>
        <ul class="menu" id="menu">
          <li><a href="portalAlumno/datosPersonales.html">Datos Personales</a></li>
          <li><a href="portalAlumno/horario.html">Horario</a></li>
          <li><a href="portalAlumno/asistencia.html">Asistencia</a></li>
          <li><a href="portalAlumno/calificaciones.html">Calificaciones</a></li>
        </ul>
      </nav>
    </header>

    <!-- Menú lateral -->
    <aside class="menu-side" id="menu-side">
      <div class="name-page">
        <i class="fa-solid fa-house" title="Panel"></i>
        <h4>Menú</h4>
      </div>
      <div class="user name-page">
        <i class="fa-solid fa-user-graduate"></i>
        <h4>Alumno</h4>
      </div>
      <div class="options-menu">
        <a href="portalAlumno/datosPersonales.html" id="data-student">
          <div class="option">
            <i class="fa-solid fa-address-card"></i>
            <h4>Datos Personales</h4>
          </div>
        </a>
        <a href="portalAlumno/horario.html" id="horario-btn">
          <div class="option">
            <i class="fa-solid fa-calendar-days"></i>
            <h4>Horario</h4>
          </div>
        </a>
        <a href="portalAlumno/asistencia.html" id="asistencia-btn">
          <div class="option">
            <i class="fa-solid fa-pen"></i>
            <h4>Asistencia</h4>
          </div>
        </a>
        <a href="portalAlumno/calificaciones.html">
          <div class="option">
            <i class="fa-solid fa-book"></i>
            <h4>Calificaciones</h4>
          </div>
        </a>
      </div>
      <div class="exit">
        <a href="index.php" title="Salir">
          <i class="fa-solid fa-right-from-bracket"></i>
        </a>
        <h4>Salir</h4>
      </div>
    </aside>

    <!--Regresar al inicio-->
    <i
      class="scrollTopBtn fa-solid fa-arrow-up"
      id="scrollTopBtn"
      title="Ir al principio"
    ></i>

    <!-- Contenido principal -->
    <main id="main">
      <section class="intro">
        <div class="intro-content" data-aos="fade-down">
          <h2>Bienvenido a ACADEMIX</h2>
          <p>
            Academix es una plataforma educativa diseñada para facilitar la
            gestión académica de manera eficiente y centralizada. Aquí, tanto
            alumnos como profesores pueden consultar, modificar y actualizar
            cualquier criterio sin tener que acudir físicamente a ningún
            departamento. Todo el proceso se realiza en línea, de forma segura,
            rápida y accesible desde cualquier dispositivo.
          </p>
          <a href="#about" class="btn-intro">Conoce más</a>
        </div>
      </section>
      <section class="about-us" id="about-us">
        <div class="about-content" data-aos="fade-up">
          <h2>Sobre los desarrolladores</h2>
          <p>
            Este portal fue diseñado y desarrollado por un equipo apasionado de
            estudiantes y profesionales de desarrollo web, con el objetivo de
            mejorar la experiencia digital de los alumnos. Nos enfocamos en
            crear una plataforma intuitiva, segura y moderna, alineada con las
            necesidades reales de la comunidad educativa.
          </p>
          <p>
            Nuestra misión es demostrar cómo la tecnología bien aplicada puede
            transformar la educación, optimizando procesos, acercando a
            estudiantes y docentes, y facilitando el acceso a la información.
          </p>
        </div>
      </section>
      <section class="focus" id="focus">
        <div class="focus-content" data-aos="fade-up">
          <h2>En lo que nos enfocamos</h2>
          <p>
            Nuestro proyecto llamado Academix tiene como compromiso brindar una
            educación de calidad que prepare a nuestros estudiantes para los
            desafíos del mundo actual. Nos enfocamos en:
          </p>
          <ul>
            <li>
              <strong>Innovación:</strong> Incorporamos metodologías modernas y
              tecnología para ofrecer una experiencia al usuario dinámica y
              efectiva.
            </li>
            <li>
              <strong>Desarrollo integral:</strong> Fomentamos tanto el
              crecimiento académico como personal, promoviendo valores como la
              responsabilidad, el trabajo en equipo y la creatividad.
            </li>
            <li>
              <strong>Atención personalizada:</strong> Adaptamos nuestros
              programas a las necesidades individuales de cada cliente/empresa
              para potenciar sus fortalezas y superar sus retos.
            </li>
            <li>
              <strong>Calidad y excelencia:</strong> Contamos con un equipo de
              desarrollo altamente capacitado y recursos actualizados para
              garantizar una formación de primer nivel.
            </li>
          </ul>
          <p>
            Nuestro objetivo es desarrollar software que se adapte a las
            necesidades académicas de cualquier escuela.
          </p>
        </div>
      </section>
    </main>

    <footer class="footer" id="contacto">
      <div class="footer-content">
        <div class="footer-section about">
          <h3>Alpha Coders</h3>
          <p>
            Somos un equipo comprometido con la excelencia del desarrollo de
            software. Brindamos excelentes servicios relacionados a la
            tecnología, para solucionar los problemas de cualquier empresa.
          </p>
        </div>

        <div class="footer-section contact-info">
          <h4>Contacto</h4>
          <p>📍 Av. Gobernadores 1234, Campeche</p>
          <p>📞 (123) 456-7890</p>
          <p>📧 contacto@academix.edu</p>
        </div>

        <div class="footer-section links">
          <h4>Enlaces útiles</h4>
          <ul>
            <li><a href="#">Opiniones</a></li>
            <li><a href="#">Empleados</a></li>
            <li><a href="#">Convenios con Empresas</a></li>
            <li><a href="#">Preguntas frecuentes</a></li>
          </ul>
        </div>

        <div class="footer-section social">
          <h4>Síguenos</h4>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f" title="Facebook"></i></a>
            <a href="#"><i class="fab fa-twitter" title="Twitter"></i></a>
            <a href="#"><i class="fab fa-instagram" title="Instagram"></i></a>
            <a href="#"><i class="fab fa-youtube" title="YouTube"></i></a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p>Desarrollado por el equipo de estudiantes de Alpha Coders — 2025</p>
        <p>© Todos los derechos reservados</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="portalAlumno/portales.js"></script>
  </body>
</html>
