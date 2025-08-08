<?php
session_start();
include("../src/conexion.php");

if (!isset($_SESSION['id_matricula']) || $_SESSION['rol'] !== 'prof') {
  echo "<script>
            alert('Por favor, inicie sesión primero');
            window.location.href='login.php';
          </script>";
  exit();
}

$idprofe = $_SESSION['id_matricula'];

$sql = "SELECT * FROM profesor WHERE matriculaP = '$idprofe'";
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
            window.location.href='horarioPro.php';
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
  <link rel="icon" href="../src/img/academix.jpg" />
  <script
    src="https://kit.fontawesome.com/e522357059.js"
    crossorigin="anonymous"></script>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link rel="stylesheet" href="../assets/css/portalProfesor/horarioPro.css?v=1.0">
  <title>Horario de Clases</title>
</head>

<body>
  <div class="horario-container" data-aos="fade-down">
    <div class="horario-header">
      <h1>Horario de Clases - Mayo a Agosto</h1>
      <br>
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
        Licenciaturas
      </caption>
      <thead>
        <tr>
          <th>Asignatura</th>
          <th>Clave</th>
          <th>Salon</th>
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
            Programación de Web I<br /><span class="profesor">
          </td>
          <td>312</td>
          <td>15</td>
          <td>5</td>
          <td></td>
          <td>10:30 - 12:30</td>
          <td>11:30 - 12:30</td>
          <td></td>
          <td>9:30 - 11:30</td>
        </tr>
        <tr>
          <td class="asignatura">
            Costos e inversion II<br /><span class="profesor">
          </td>
          <td>112</td>
          <td>10</td>
          <td>5</td>
          <td>9:30 - 10:30</td>
          <td></td>
          <td>7:00 - 9:00</td>
          <td></td>
          <td>11:30 - 1:30</td>
        </tr>
        <tr>
          <td class="asignatura">
            Seguridad informatica<br /><span class="profesor">
          </td>
          <td>214</td>
          <td>6</td>
          <td>9</td>
          <td>7:00 - 9:00</td>
          <td>10:30 - 12:30</td>
          <td>12:00 - 1:00</td>
          <td>9:30 - 11:30</td>
          <td>11:00 - 1:00</td>
        </tr>
      </tbody>
    </table>

    <div class="container-submit">
      <button class="btn" onclick="abrirModal()">Reportar un problema</button>
      <button class="btn" id="btn-modified-schedule">
        Enviar horario modificado
      </button>
      <button class="btn add-subject" id="add-subject" onclick="agregarMateria()">
        Agregar materia
      </button>
    </div>

  </div>

  <!--Botón salir-->
  <div class="exit-rsp" onclick="returnMenuProf()">
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
          name="matriculaP"
          value="<?php echo $_SESSION['id_matricula']; ?>" />
        <input
          type="number"
          name="matriculaA"
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
  <script src="../assets/js/portalProfesor/horarioPro.js"></script>
</body>

</html>