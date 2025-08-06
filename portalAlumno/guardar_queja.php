<?php
session_start();
include '../src/conexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_set_charset($conn, "utf8");

$matriculaA = $_POST['matriculaA'];
$matriculaP = $_POST['matriculaP'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO quejas (matriculaA, matriculaP, asunto, mensaje)
        VALUES ('$matriculaA', '$matriculaP', '$asunto', '$mensaje')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Reporte enviado con éxito');
            window.location.href = '../portalAlumno.php';
          </script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

