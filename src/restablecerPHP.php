<?php 
    include "./conexion.php";
    $email =$_POST['email'];
    $bytes = random_bytes(5);
    $token =bin2hex($bytes);

    include "mail_reset.php";
    if($enviado){
        $conexion->query(" insert into passwords(email, token, codigo) 
         values('$email','$token','$codigo') ") or die($conexion->error);
         header("Location: ../login.php");
    } else {
        echo 'no se envio';
    }
   

?>