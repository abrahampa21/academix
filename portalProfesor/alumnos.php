<?php
session_start();
include("../src/conexion.php");

// Validar que el usuario sea profesor
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'prof') {
    echo "<script>
            alert('Acceso denegado'); 
            window.location.href='login.php';
          </script>";
    exit();
}

// Consultar lista de alumnos
$sql = "SELECT * FROM alumno ORDER BY nombreCompleto ASC";
$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/e522357059.js"
      crossorigin="anonymous"
    ></script>
    <link rel="icon" href="../src/img/academix.jpg" />
    <link rel="stylesheet" href="../assets/css/portalProfesor/alumnos.css" />
    <title>Alumnos</title>
    <!-- Google tag (gtag.js) -->
    <script
      async
      src="https://www.googletagmanager.com/gtag/js?id=G-4G187DGVGB"
    ></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());
      gtag("config", "G-4G187DGVGB");
    </script>
  </head>
  <body>
    <div class="container" data-aos="fade-down">
      <table class="alumnos" id="alumnos">
        <thead>
          <tr>
            <th>Alumno</th>
            <th>Asistencia</th>
            <th>Calificación</th>
            <th>Puntos extras</th>
            <th>Asignatura</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td data-label="Alumno"><?= htmlspecialchars($row['nombreCompleto']) ?></td>
            <td data-label="Asistencia">
              <a href="../portalAlumno/asistencia.php?matricula=<?= urlencode($row['matriculaA']) ?>">Ver asistencias</a>
            </td>
            <td data-label="Calificación">--</td>
            <td data-label="Puntos Extras">--</td>
            <td data-label="Asignatura"><?= htmlspecialchars($row['asignatura']) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div class="container-submit">
        <button class="btn" id="btn-modified-schedule" onclick="authorized()">
          Modificar datos
        </button>
        <button class="btn add-subject" id="btn-modified-students">
          Actualizar datos
        </button>
      </div>
    </div>

    <!--Botón salir-->
    <div class="exit-rsp" onclick="returnMenu()">
      <a href="#" title="Salir">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="../assets/js/portalProfesor/alumnos.js"></script>
  </body>
</html>
