<?php
session_start();
include("../src/conexion.php");
 
if (
    !isset($_SESSION['id_matricula']) && // No es alumno
    !(
        isset($_SESSION['rol']) &&
        $_SESSION['rol'] === 'prof' &&
        isset($_GET['matricula'])
    )
) {
    echo "<script>alert('Por favor, inicie sesión primero'); window.location.href='../login.php';</script>";
    exit();
}

if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'alu') {
    $idalum = $_SESSION['id_matricula'];
} elseif ($_SESSION['rol'] === 'prof' && isset($_GET['matricula'])) {
    $idalum = $_GET['matricula'];
}

$sql = "SELECT * FROM alumno WHERE matriculaA = '$idalum'";
$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);

?>

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
          
            window.location.href='asistencia.php';
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
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap"
    rel="stylesheet" />
  <script
    src="https://kit.fontawesome.com/e522357059.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link rel="icon" href="../src/img/academix.jpg" />
  <link rel="stylesheet" href="../assets/css/portalAlumno/asistencia.css?v=1.0" />
  <title>Asistencias</title>
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
  <div
    class="container"
    id="asistencias-alumno"
    data-aos="fade-down"
    data-aos-duration="800">
    <h4>Alumno: <?php echo $row['nombreCompleto'] ?></h4>
    <h4>Matrícula: <?php echo $row['matriculaA'] ?></h4>
    <table class="asistencia" id="asistencia">
      <tbody>
        <tr>
          <th>Mes</th>
          <th>Total de clases</th>
          <th>Total de asistencias</th>
          <th>Total de faltas</th>
          <th>Porcentaje total de asistencias</th>
        </tr>
        <tr>
          <td>SEPTIEMBRE</td>
          <td>12</td>
          <td>12</td>
          <td>0</td>
          <td>100%</td>
        </tr>
        <tr>
          <td>OCTUBRE</td>
          <td>12</td>
          <td>12</td>
          <td>0</td>
          <td>100%</td>
        </tr>
        <tr>
          <td>NOVIEMBRE</td>
          <td>12</td>
          <td>12</td>
          <td>0</td>
          <td>100%</td>
        </tr>
        <tr>
          <td>DICIEMBRE</td>
          <td>12</td>
          <td>11</td>
          <td>1</td>
          <td>91.7%</td>
        </tr>
        <tr class="resultado">
          <td>Resultado</td>
          <td>48</td>
          <td>47</td>
          <td>1</td>
          <td>97.9%</td>
        </tr>
      </tbody>
    </table>
    <br />
    <button class="btn" onclick="abrirModal()">Reportar un problema</button>
    <button class="btn" type="submit" onclick="descargarPDF()">Descargas asistencias en PDF</button>
  </div>

  <!--Botón salir-->
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
  <script src="../assets/js/portalAlumno/asistencia.js"></script>
</body>

</html>