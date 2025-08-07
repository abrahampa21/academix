<?php
session_start();
include("../src/conexion.php");

if (!isset($_SESSION['id_matricula']) || $_SESSION['rol'] !== 'prof') {
    echo "Acceso no autorizado.";
    exit;
}

$matricula_profesor = $_SESSION['id_matricula'];

// Procesar respuesta si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['responder'])) {
    $id_mensaje = $_POST['id'];
    $respuesta = $_POST['respuesta'];
    $estado = $_POST['estado'];

    $stmt = $conexion->prepare("UPDATE quejas SET respuesta = ?, estado = ? WHERE id = ? AND matriculaP = ?");
    $stmt->bind_param("ssis", $respuesta, $estado, $id_mensaje, $matricula_profesor);
    $stmt->execute();
}

// Obtener mensajes dirigidos al profesor
$sql = "SELECT id, asunto, mensaje, matriculaA, estado, respuesta FROM quejas WHERE matriculaP = ? and estado='pendiente'";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $matricula_profesor);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Avisos y Mensajes</title>
  <link rel="icon" href="../src/img/academix.jpg" />
  <script src="https://kit.fontawesome.com/e522357059.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <link rel="stylesheet" href="../assets/css/portalProfesor/horarioPro.css?v=1.0">
  <style>
    textarea {
        width: 100%;
        resize: vertical;
        min-height: 60px;
    }
    select {
        padding: 5px;
        font-size: 16px;
  border-radius: 5px;
  background-color: #e2e8f0;
  color: #000;
    }
    button[type="submit"] {
        padding: 6px 12px;
        background-color: #2c8bff;
        color: white;
        border: none;
        cursor: pointer;

        font-family: "Plus Jakarta Sans", sans-serif;
  border-radius: 3px;
  background-color: #1a3d7c;
  color: #fff;
  transition: 0.3s;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
    }
  </style>
</head>
<body>
  <div class="horario-container" data-aos="fade-down">
    <div class="horario-header">
      <h1>Buzón de Avisos y Mensajes</h1><br>
    </div>
    <table id="notificaciones">
      <thead>
        <tr>
          <th>Asunto</th>
          <th>Mensaje</th>
          <th>Remitente</th>
          <th>Estado</th>
          <th>Respuesta</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <form method="post">
                <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                <td><?php echo htmlspecialchars($row['mensaje']); ?></td>
                <td><?php echo htmlspecialchars($row['matriculaA']); ?></td>
                <td>
                  <select name="estado">
                    <option value="pendiente" <?= $row['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="respondida" <?= $row['estado'] === 'respondida' ? 'selected' : '' ?>>Respondida</option>
                  </select>
                </td>
                <td>
                  <textarea name="respuesta"><?php echo htmlspecialchars($row['respuesta']); ?></textarea>
                </td>
                <td>
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="responder">Enviar</button>
                </td>
              </form>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;">No hay mensajes para mostrar.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="exit-rsp" onclick="returnMenu()">
    <a href="#" title="Salir"><i class="fa-solid fa-arrow-left"></i></a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../assets/js/portalProfesor/horarioPro.js"></script>
</body>
</html>
