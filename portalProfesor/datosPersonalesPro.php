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


//Actualizar Datos Personales
if (isset($_POST["actualizar"])) {
  $fechaNac = mysqli_real_escape_string($conexion, $_POST['fechaNac']);
  $periodo = mysqli_real_escape_string($conexion, $_POST['periodo']);
  $status = mysqli_real_escape_string($conexion, $_POST['estatus']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

  if (empty($fechaNac) || empty($periodo) || empty($status) || empty($direccion)) {
    echo "<script>
            alert('Por favor, complete todos los campos');
            window.location.href='datosPersonalesPro.php';
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

  $sql = "UPDATE profesor SET fechaNac  = '$fechaNac', periodo  = '$periodo', estatus  = '$status', direccion = '$direccion' WHERE matriculaP = '$idprofe'";

  mysqli_query($conexion, $sql);
}

$sql = "SELECT * FROM profesor WHERE matriculaP = '$idprofe'";
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
  <link rel="icon" href="../src/img/academix.jpg" />
  <link
    rel="stylesheet"
    href="../assets/css/portalProfesor/datosPersonalesPro.css?v=1.0" />
  <script
    src="https://kit.fontawesome.com/e522357059.js"
    crossorigin="anonymous"></script>
  <title>Datos Personales</title>
</head>

<body>
  <form
    onsubmit="confirmation(event)"
    method="POST"
    class="data-teacher"
    id="data-teacher"
    data-aos="fade-down">
    <table>
      <caption>
        Tus Datos Personales
      </caption>
      <tr>
        <th>Tu nombre</th>
        <td><?php echo $row['nombreCompleto'] ?></td>
      </tr>
      <tr>
        <th>Matrícula</th>
        <td><?php echo $row['matriculaP'] ?></td>
      </tr>
      <tr>
        <th>Correo Electrónico</th>
        <td><?php echo $row['email'] ?></td>
      </tr>
      <tr>
        <th>
          Fecha de Nacimiento <i class="fa-solid fa-pen" id="pen-date" data-input="fecha-nac"></i>
        </th>
        <td>
          <input
            type="date"
            class="dp-inputs"
            name="fechaNac"
            id="fechaNac"
            readonly
            title="u"
            onclick="modifyInfo()" />
        </td>
      </tr>
      <tr>
        <th>Periodo <i class="fa-solid fa-pen" data-input="periodo"></i></th>
        <td>
          <input
            type="text"
            class="dp-inputs"
            name="periodo"
            id="periodo"
            readonly
            required />
        </td>
      </tr>
      <tr>
        <th>Estatus <i class="fa-solid fa-pen" data-input="estatus"></i></th>
        <td>
          <select name="estatus" class="status" id="estatus" disabled>
            <option value="contrato">Contrato</option>
            <option value="medio-tiempo">Medio tiempo</option>
            <option value="tiempo-completo">Tiempo completo</option>
          </select>
        </td>
      </tr>
      <tr>
        <th>
          Domicilio Actual
          <i class="fa-solid fa-pen" data-input="direccion"></i>
        </th>
        <td>
          <input
            type="text"
            class="dp-inputs"
            name="direccion"
            id="direccion"
            readonly
            required />
        </td>
      </tr>
    </table>
    <button type="submit" class="submit" id="submit" name="actualizar">
      Actualizar datos
    </button>
  </form>

  <!--Botón salir-->
  <div class="exit-rsp">
    <a href="../portalProfesor.php" title="Salir">
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="../assets/js/portalProfesor/datosPersonalesPro.js"></script>
</body>

</html>