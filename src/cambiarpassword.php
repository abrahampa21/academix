<?php 
    include "conexion.php";
    $email =$_POST['email'];
    $p1 =$_POST['p1'];
    $p2 =$_POST['p2'];
    if($p1 == $p2){
        $p1=sha1($p1);
        $conexion->query("update alumno set password='$p1' where email='$email' ") or die($conexion->error);
        $conexion->query("update profesor set password='$p1' where email='$email' ") or die($conexion->error);
        header("Location: ../login.php");
        
    }else{
        echo "Las contraseñas no coinciden";
    }
?>