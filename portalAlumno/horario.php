<?php
session_start();
include("../src/conexion.php");

if (!isset($_SESSION['id_matricula']) || $_SESSION['rol'] !== 'alu') {
  echo "<script>
            alert('Por favor, inicie sesión primero');
            window.location.href='login.php';
          </script>";
  exit();
}

$idalum = $_SESSION['id_matricula'];

$sql = "SELECT * FROM alumno WHERE matriculaA = '$idalum'";
$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../src/img/academix.jpg" />
    <script
      src="https://kit.fontawesome.com/e522357059.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/portalAlumno/horario.css" />
    <title>Horario de Clases</title>
  </head>
  <body>
    <div class="horario-container" data-aos="fade-down">
      <div class="horario-header">
        <h1>Horario de Clases - Mayo a Agosto</h1>
        <br />
        <div class="buttons-modified">
          <button class="botoncitos" id="botoncito" onclick="descargarPDF()">
            Descargar como PDF
          </button>
          <button class="botoncitos" onclick="authorized()">
            Modificar Horario
          </button>
        </div>
      </div>
      <table id="horario">
        <caption>
          <?php echo $row['carrera'] ?>
        </caption>
        <thead>
          <tr>
            <th>Asignatura</th>
            <th>Clave</th>
            <th>Horas/Semana</th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miércoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="asignatura">
              Propaganda y Medios<br /><span class="profesor"
                >Mtro. Omar Enrique Kantun</span
              >
            </td>
            <td>311</td>
            <td>3</td>
            <td></td>
            <td>7:00 - 9:00</td>
            <td></td>
            <td></td>
            <td>8:00 - 9:00</td>
          </tr>
          <tr>
            <td class="asignatura">
              Programación de Web I<br /><span class="profesor"
                >I.S.C. Edward Enrique Morales</span
              >
            </td>
            <td>312</td>
            <td>5</td>
            <td>10:30 - 12:30</td>
            <td></td>
            <td>11:30 - 12:30</td>
            <td></td>
            <td>9:30 - 11:30</td>
          </tr>
          <tr>
            <td class="asignatura">
              Redes I<br /><span class="profesor"
                >I.S.C. Luis Manuel Cambranis</span
              >
            </td>
            <td>313</td>
            <td>5</td>
            <td></td>
            <td>9:30 - 11:30</td>
            <td></td>
            <td>9:30 - 11:30</td>
            <td>7:00 - 8:00</td>
          </tr>
          <tr>
            <td class="asignatura">
              Lenguaje PHP y Java<br /><span class="profesor"
                >Lic. Cesar Ricardo Cen Poot</span
              >
            </td>
            <td>314</td>
            <td>6</td>
            <td>8:00 - 10:00</td>
            <td></td>
            <td>9:30 - 11:30</td>
            <td>11:30 - 13:30</td>
            <td></td>
          </tr>
          <tr>
            <td class="asignatura">
              Diseño de Páginas Web<br /><span class="profesor"
                >Mtro. Abraham Izoteco Valle</span
              >
            </td>
            <td>315</td>
            <td>4</td>
            <td></td>
            <td></td>
            <td>7:00 - 9:00</td>
            <td>7:00 - 9:00</td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div class="buttons-submit">
        <button class="btn" onclick="abrirModal()">Reportar un problema</button>
        <button class="btn" id="btn-modified-schedule">
          Enviar horario modificado
        </button>
      </div>
    </div>

    <!--Botón salir-->
    <div class="exit-rsp">
      <a href="../portalAlumno.php" title="Salir">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
    </div>

    <!--Reporte -->
    <div data-aos="zoom-in" class="modal" id="modalReporte">
      <form class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h3>Reportar Problema</h3>
        <div class="destinatario">
          <h4>Destinatario</h4>
          <input
            type="email"
            name=""
            title="u"
            placeholder="eg. itesrenedescartes.edu.mx"
            id=""
            required
          />
        </div>
        <textarea
          rows="5"
          placeholder="Describe el problema..."
          required
        ></textarea>
        <br /><br />
        <button class="btn" type="submit">Enviar Reporte</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="../assets/js/portalAlumno/horario.js"></script>
  </body>
</html>
