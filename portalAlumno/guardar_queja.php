<?php
session_start();
include '../src/conexion.php';

$matriculaA = $_POST['matriculaA'];
$matriculaP = $_POST['matriculaP'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO quejas (matriculaA, matriculaP, asunto, mensaje) 
        VALUES ('$matriculaA', '$matriculaP', '$asunto', '$mensaje')";

if (mysqli_query($conn, $sql)) {
    header("Location: portalAlumno.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
