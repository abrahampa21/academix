<?php 
    $conexion = new mysqli('localhost','root','alcoceresquivel','sistema');
    if($conexion-> connect_error){
        die('No se pudo conectar al servidor');
    }

?>