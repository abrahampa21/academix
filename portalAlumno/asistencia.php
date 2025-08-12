<?php
session_start();
include("../src/conexion.php");
mysqli_set_charset($conexion, "utf8");

// Validar sesión y permisos
if (
    !isset($_SESSION['id_matricula']) &&
    !(
        isset($_SESSION['rol']) &&
        $_SESSION['rol'] === 'prof' &&
        isset($_GET['matricula'])
    )
) {
    echo "<script>alert('Por favor, inicie sesión primero'); window.location.href='../login.php';</script>";
    exit();
}

// Obtener matrícula según rol
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'alu') {
    $idalum = $_SESSION['id_matricula'];
} elseif ($_SESSION['rol'] === 'prof' && isset($_GET['matricula'])) {
    $idalum = $_GET['matricula'];
}

$esProfesor = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'prof');

// Procesar formulario para guardar asistencias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $esProfesor) {
    $matriculaA = $_POST['matriculaA'];
    $meses = $_POST['mes'];
    $totalClases = $_POST['total_clases'];
    $totalAsist = $_POST['total_asist'];

    // Validar existencia del alumno
    $sqlCheck = "SELECT 1 FROM alumno WHERE matriculaA = '$matriculaA' LIMIT 1";
    $resCheck = mysqli_query($conexion, $sqlCheck);
    if (mysqli_num_rows($resCheck) === 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La matrícula $matriculaA no existe en la base de datos.',
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit();
    }

    // Insertar o actualizar sin duplicar
    for ($i = 0; $i < count($meses); $i++) {
        $faltas = $totalClases[$i] - $totalAsist[$i];
        $porcentaje = $totalClases[$i] > 0 ? ($totalAsist[$i] / $totalClases[$i] * 100) : 0;

        $sql = "INSERT INTO asistencias (matriculaA, mes, total_clases, total_asist, total_faltas, porcentaje)
                VALUES ('$matriculaA', '{$meses[$i]}', {$totalClases[$i]}, {$totalAsist[$i]}, $faltas, $porcentaje)
                ON DUPLICATE KEY UPDATE
                  total_clases = VALUES(total_clases),
                  total_asist = VALUES(total_asist),
                  total_faltas = VALUES(total_faltas),
                  porcentaje = VALUES(porcentaje)";

        if (!mysqli_query($conexion, $sql)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: '" . mysqli_error($conexion) . "',
                }).then(() => {
                    window.history.back();
                });
            </script>";
            exit();
        }
    }

    // Mostrar éxito y recargar página
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Actualizado',
        text: 'Los datos se actualizaron correctamente.',
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.location.href = window.location.href;
      });
    </script>";
}

// Cargar datos alumno
$sqlAlumno = "SELECT * FROM alumno WHERE matriculaA = '$idalum'";
$resultAlumno = mysqli_query($conexion, $sqlAlumno);
$alumno = mysqli_fetch_assoc($resultAlumno);

// Cargar asistencias alumno
$sqlAsistencias = "SELECT * FROM asistencias WHERE matriculaA = '$idalum'";
$resultAsistencias = mysqli_query($conexion, $sqlAsistencias);
$asistencias = [];
while ($fila = mysqli_fetch_assoc($resultAsistencias)) {
    $asistencias[$fila['mes']] = $fila;
}

// Si no hay registros, inicializar meses default
$mesesDefault = ["SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
foreach ($mesesDefault as $mes) {
    if (!isset($asistencias[$mes])) {
        $asistencias[$mes] = [
            'mes' => $mes,
            'total_clases' => 0,
            'total_asist' => 0,
            'total_faltas' => 0,
            'porcentaje' => 0
        ];
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
    <h4>Alumno: <?php echo htmlspecialchars($alumno['nombreCompleto']); ?></h4>
    <h4>Matrícula: <?php echo htmlspecialchars($alumno['matriculaA']); ?></h4>

    <form method="post" id="formAsistencias" novalidate>
      <input type="hidden" name="matriculaA" value="<?php echo htmlspecialchars($idalum); ?>" />
      <table class="asistencia" id="asistencia">
        <tbody>
          <tr>
            <th>Mes</th>
            <th>Total de clases</th>
            <th>Total de asistencias</th>
            <th>Total de faltas</th>
            <th>Porcentaje total de asistencias</th>
          </tr>
          <?php foreach ($asistencias as $a): ?>
          <tr>
            <td>
              <?php echo htmlspecialchars($a['mes']); ?>
              <input type="hidden" name="mes[]" value="<?php echo htmlspecialchars($a['mes']); ?>" />
            </td>
            <td>
              <?php if ($esProfesor): ?>
              <input
                type="number"
                min="0"
                name="total_clases[]"
                value="<?php echo (int)$a['total_clases']; ?>"
                required
                disabled />
              <?php else: ?>
              <?php echo (int)$a['total_clases']; ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($esProfesor): ?>
              <input
                type="number"
                min="0"
                name="total_asist[]"
                value="<?php echo (int)$a['total_asist']; ?>"
                required
                disabled />
              <?php else: ?>
              <?php echo (int)$a['total_asist']; ?>
              <?php endif; ?>
            </td>
            <td class="faltas"><?php echo (int)$a['total_faltas']; ?></td>
            <td class="porcentaje"><?php echo number_format($a['porcentaje'], 1); ?>%</td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if ($esProfesor): ?>
      <br />
      <button type="button" id="btnModificar" class="btn">Modificar datos</button>
      <button type="submit" id="btnGuardar" class="btn" disabled>Guardar cambios</button>
      <?php endif; ?>
    </form>

    <br />
    <button class="btn" onclick="abrirModal()">Reportar un problema</button>
    <button class="btn" type="button" onclick="descargarPDF()">Descargas asistencias en PDF</button>
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
          placeholder="Escriba el asunto de la queja"
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
          placeholder="Escribe la matricula del destinatario"
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

  <script>
  <?php if ($esProfesor): ?>
  const btnModificar = document.getElementById("btnModificar");
  const btnGuardar = document.getElementById("btnGuardar");
  const inputsClases = document.querySelectorAll("input[name='total_clases[]']");
  const inputsAsist = document.querySelectorAll("input[name='total_asist[]']");

  btnModificar.addEventListener("click", () => {
    inputsClases.forEach(input => input.disabled = false);
    inputsAsist.forEach(input => input.disabled = false);

    btnGuardar.disabled = false;
    btnModificar.disabled = true;
  });

  // Cálculo automático para actualización en vivo
  document.querySelectorAll("input[name='total_clases[]'], input[name='total_asist[]']").forEach(input => {
    input.addEventListener("input", function () {
      const row = input.closest("tr");
      const totalClases = parseInt(row.querySelector("input[name='total_clases[]']").value) || 0;
      let totalAsist = parseInt(row.querySelector("input[name='total_asist[]']").value) || 0;

      if (totalAsist > totalClases) {
        totalAsist = totalClases;
        row.querySelector("input[name='total_asist[]']").value = totalClases;
      }

      const faltas = totalClases - totalAsist;
      const porcentaje = totalClases > 0 ? (totalAsist / totalClases * 100).toFixed(1) : 0;

      row.querySelector(".faltas").textContent = faltas;
      row.querySelector(".porcentaje").textContent = porcentaje + "%";
    });
  });
  <?php endif; ?>
  </script>
</body>

</html>
