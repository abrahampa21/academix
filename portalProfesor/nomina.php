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
            window.location.href='nomina.php';
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
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/portalProfesor/nomina.css" />
  <title>Nómina del Profesor</title>
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
  <div class="container" data-aos="fade-down">
    <h2>Historial de Nómina</h2>

    <div class="filters">
      <div>
        <label for="filtroAño">Filtrar por año:</label>
        <select id="filtroAño">
          <option value="todos">Todos</option>
          <option value="2025">2025</option>
          <option value="2024">2024</option>
        </select>
      </div>

      <div>
        <label for="filtroMes">Filtrar por mes:</label>
        <select id="filtroMes">
          <option value="todos">Todos</option>
          <option value="Julio">Julio</option>
          <option value="Junio">Junio</option>
          <option value="Mayo">Mayo</option>
        </select>
      </div>
    </div>

    <div class="container-responsive">
      <table class="nomina" id="tablaNomina">
        <thead>
          <tr>
            <th>Mes</th>
            <th>Periodo</th>
            <th>Salario Neto</th>
            <th>Estatus</th>
            <th>Recibo</th>
          </tr>
        </thead>
        <tbody>
          <tr data-anio="2025" data-mes="Julio">
            <td data-label="Mes">Julio 2025</td>
            <td data-label="Periodo">01/07/2025 - 31/07/2025</td>
            <td data-label="Salario Neto">$18,500 MXN</td>
            <td data-label="Estatus">Pagado</td>
            <td data-label="Recibo"><a href="#" class="btn">Descargar PDF</a></td>
          </tr>
          <tr data-anio="2025" data-mes="Junio">
            <td data-label="Mes">Junio 2025</td>
            <td data-label="Periodo">01/06/2025 - 30/06/2025</td>
            <td data-label="Salario Neto">$18,500 MXN</td>
            <td data-label="Estatus">Pagado</td>
            <td data-label="Recibo"><a href="#" class="btn">Descargar PDF</a></td>
          </tr>
          <tr data-anio="2025" data-mes="Mayo">
            <td data-label="Mes">Mayo 2025</td>
            <td data-label="Periodo">01/05/2025 - 31/05/2025</td>
            <td data-label="Salario Neto">$18,500 MXN</td>
            <td data-label="Estatus">Pagado</td>
            <td data-label="Recibo"><a href="#" class="btn">Descargar PDF</a></td>
          </tr>
        </tbody>
      </table>
    </div>

    <br />
    <button class="btn" onclick="abrirModal()">
      Reportar Problema con Pago
    </button>
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

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="../assets/js/portalProfesor/nomina.js"></script>
</body>

</html>