<?php
session_start();
include '../src/conexion.php';
mysqli_set_charset($conexion, "utf8");

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $matriculaA = $_POST['matriculaA'];
  $matriculaP = $_POST['matriculaP'];
  $asunto = $_POST['asunto'];
  $mensaje = $_POST['mensaje'];

  $sql = "INSERT INTO quejas (matriculaA, matriculaP, asunto, mensaje)
            VALUES ('$matriculaA', '$matriculaP', '$asunto', '$mensaje')";

  if (mysqli_query($conexion, $sql)) {
    echo "<script>
          
            window.location.href='calificaciones.php';
          </script>";
    exit();
  } else {
    echo "<script>alert('Error: " . mysqli_error($conexion) . "');</script>";
  }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
  <link rel="icon" href="../src/img/academix.jpg" />
  <link
    rel="stylesheet"
    href="../assets/css/portalAlumno/calificaciones.css" />
  <script
    src="https://kit.fontawesome.com/e522357059.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <title>Tabla de Calificaciones</title>
  <!-- Google tag (gtag.js) -->
  <script
    async
    src="https://www.googletagmanager.com/gtag/js?id=G-4G187DGVGB"></script>
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
  <div class="tabla-container" data-aos="fade-down">
    <table class="tabla-calificaciones" id="calificaciones">
      <caption>
        Calificaciones del Alumno
      </caption>
      <thead>
        <tr>
          <th>Materia</th>
          <th>Parcial 1</th>
          <th>Parcial 2</th>
          <th>Parcial 3</th>
          <th>Promedio Final</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Matemáticas</td>
          <td>8.5</td>
          <td>9.0</td>
          <td>8.7</td>
          <td>8.7</td>
        </tr>
        <tr>
          <td>Historia</td>
          <td>9.2</td>
          <td>9.5</td>
          <td>9.0</td>
          <td>9.2</td>
        </tr>
        <tr>
          <td>Ciencias</td>
          <td>8.0</td>
          <td>8.5</td>
          <td>9.0</td>
          <td>8.5</td>
        </tr>
        <tr>
          <td>Inglés</td>
          <td>9.0</td>
          <td>9.3</td>
          <td>9.1</td>
          <td>9.1</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4">Promedio General</th>
          <th>8.9</th>
        </tr>
      </tfoot>
    </table>

    <br />
    <button class="btn" onclick="abrirModal()">Reportar un problema</button>
    <button class="btn" onclick="descargarPDF()">Descargar boleta en PDF</button>
  </div>

  <!--Botón regresar-->
  <div class="exit-rsp" onclick="returnMenu()">
    <a href="#" title="Salir">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </div>

  <!--Reporte -->
  <div class="modal" id="modalReporte">
    <form class="modal-content" method="post">
      <span class="close" onclick="cerrarModal()">&times;</span>
      <h3>Reportar Problema</h3>
      <div class="destinatario">
        <h4>Destinatario</h4>
        <input
          type="text"
          name="asunto"
          title="u"
          placeholder="Escriba el asunto de la queja"
          id=""
          required />
        <?php
        if (!isset($_SESSION['id_matricula'])) {
          echo "<script>alert('Sesión expirada o no iniciada. Vuelve a iniciar sesión'); window.location.href='../login.php';</script>";
          exit;
        }
        ?>

        <input
          type="hidden"
          name="matriculaA"
          value="<?php echo $_SESSION['id_matricula']; ?>" />
        <input
          type="number"
          name="matriculaP"
          title="u"
          placeholder="Escribe la matricula del destinatario"
          id=""
          maxlength="7"
          required />

      </div>
      <textarea
        rows="5"
        placeholder="Describe el problema..."
        required
        name="mensaje"></textarea>
      <br /><br />
      <button class="btn" type="submit">Enviar Reporte</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="../assets/js/portalAlumno/calificaciones.js"></script>
</body>

</html>