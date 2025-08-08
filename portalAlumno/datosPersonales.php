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


//Actualizar Datos Personales
if (isset($_POST["actualizar"])) {
  $fechaNac = mysqli_real_escape_string($conexion, $_POST['fechaNac']);
  $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
  $periodo = mysqli_real_escape_string($conexion, $_POST['periodo']);
  $status = mysqli_real_escape_string($conexion, $_POST['estatus']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

  if (empty($fechaNac) || empty($carrera) || empty($periodo) || empty($status) || empty($direccion)) {
    echo "<script>
            alert('Por favor, complete todos los campos');
            window.location.href='datosPersonales.php';
          </script>";
    exit();
  }

  //Código para el sweetalert
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire('¡Datos enviados exitosamente a la escuela!').then(() => {
                  window.location.href = 'datosPersonales.php';
              });
          });
  </script>";

  $sql = "UPDATE alumno SET
              fechaNac = '$fechaNac',
              carrera  = '$carrera',
              periodo  = '$periodo',
              estatus  = '$status',
              direccion = '$direccion' WHERE matriculaA = '$idalum'";

  mysqli_query($conexion, $sql);
}

$sql = "SELECT * FROM alumno WHERE matriculaA = '$idalum'";
$resultado = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="../src/img/academix.jpg" />
  <link rel="stylesheet" href="../assets/css/portalAlumno/datosPersonales.css">
  <title>Datos Personales</title>
</head>

<body>
  <form method="POST" class="personal-data" id="personal-data" data-aos="fade-down" autocomplete="off">
    <table>
      <caption>
        Tus Datos Personales
      </caption>
      <tr>
        <th>Nombre:</th>
        <td><?php echo $row['nombreCompleto'] ?></td>
      </tr>
      <tr>
        <th>Matrícula</th>
        <td><?php echo $row['matriculaA'] ?></td>
      </tr>
      <tr>
        <th>Correo Electrónico</th>
        <td><?php echo $row['email'] ?></td>
      </tr>
      <tr>
        <th>
          Fecha de Nacimiento
        </th>
        <td>
          <input
            type="date"
            class="dp-inputs"
            required
            name="fechaNac"
            id="fechaNac"
            readonly
            value="<?php echo $row['fechaNac'] ?>" />
        </td>
      </tr>
      <tr>
        <th>Carrera</th>
        <td>
          <select
            class="status"
            name="carrera"
            id="carrera"
            required
            disabled>
            <option value="Pedagogía" <?= strtolower(trim($row['carrera'])) === 'pedagogía' ? 'selected' : '' ?>>Pedagogía</option>
            <option value="Administración de Empresas" <?= strtolower(trim($row['carrera'])) === 'administración de empresas' ? 'selected' : '' ?>>Administración de Empresas</option>
            <option value="Programación y Webmaster" <?= strtolower(trim($row['carrera'])) === 'programación y webmaster' ? 'selected' : '' ?>>Programación y Webmaster</option>
            <option value="Artes Culinarias" <?= strtolower(trim($row['carrera'])) === 'artes culinarias y negocios gastronómicos' ? 'selected' : '' ?>>Artes Culinarias y Negocios Gastronómicos</option>
            <option value="Derecho" <?= strtolower(trim($row['carrera'])) === 'derecho' ? 'selected' : '' ?>>Derecho</option>
            <option value="Contaduría" <?= strtolower(trim($row['carrera'])) === 'contaduría' ? 'selected' : '' ?>>Contaduría</option>
          </select>

        </td>
      </tr>
      <tr>
        <th>Periodo</th>
        <td>
          <select
            name="periodo"
            class="status"
            id="periodo"
            required
            disabled>
            <option value="Enero - Abril" <?= strtolower(trim($row['periodo'])) === 'enero - abril' ? 'selected' : '' ?>>Enero - Abril</option>
            <option value="Abril - Agosto" <?= strtolower(trim($row['periodo'])) === 'abril - agosto' ? 'selected' : '' ?>>Abril - Agosto</option>
            <option value="Septiembre - Diciembre" <?= strtolower(trim($row['periodo'])) === 'septiembre - diciembre' ? 'selected' : '' ?>>Septiembre - Diciembre</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>Estatus</th>
        <td>
          <select name="estatus" class="status" id="estatus" disabled>
            <option value="Ninguno" <?= strtolower(trim($row['estatus'])) === 'ninguno' ? 'selected' : '' ?>>Ninguno</option>
            <option value="Regular" <?= strtolower(trim($row['estatus'])) === 'regular' ? 'selected' : '' ?>>Regular</option>
            <option value="Irregular" <?= strtolower(trim($row['estatus'])) === 'irregular' ? 'selected' : '' ?>>Irregular</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>
          Domicilio Actual
        </th>
        <td>
          <input
            type="text"
            class="dp-inputs"
            name="direccion"
            id="direccion"
            readonly
            required
            value="<?php echo $row['direccion'] ?>" />
        </td>
      </tr>
    </table>
    <div class="buttons-submit">
      <button class="submit" onclick="modificar(event)">
        Modificar datos
      </button>
      <button type="submit" class="submit" id="submit" name="actualizar" onclick="confirmation(event)">
        Actualizar datos
      </button>
    </div>
  </form>



  <!--Botón salir-->
  <div class="exit-rsp" onclick="returnMenu()">
    <a href="portalAlumno.php" title="Salir">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="../assets/js/portalAlumno/datosPersonales.js"></script>
</body>

</html>