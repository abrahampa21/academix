<?php
// Varios destinatarios
$para .= 'wez@example.com';

// título
$título = 'Restablecer tu contraseña';
$codigo= rand(1000,9999);


// mensaje
$mensaje = '
<html>
<head>
  <meta charset="UTF-8">
  <title>Restablecer tu contraseña</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f4f4f4;">
  <div style="max-width:600px; margin:50px auto; background-color:#ffffff; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
    <h1 style="color:#2c3e50; text-align:center;">Academix: Recupera el Acceso a tu Cuenta</h1>
    
    <div style="margin-top:20px; text-align:center; background-color:#ecf0f1; padding:20px; border-radius:8px;">
      <p style="font-size:18px; color:#34495e; margin-bottom:10px;">Has solicitado restablecer tu contraseña</p>
      <h3 style="color:#2980b9; font-size:32px; margin:10px 0;">'.$codigo.'</h3>
      <p style="font-size:16px; color:#2c3e50;">
        <a href="http://127.0.0.1/academix/src/reset.php?email='.$email.'&token='.$token.'" 
           style="display:inline-block; padding:12px 24px; margin-top:15px; background-color:#3498db; color:#ffffff; text-decoration:none; border-radius:5px;">
          Da clic aquí para restablecer tu contraseña
        </a>
      </p>
      <p style="font-size:12px; color:#7f8c8d; margin-top:20px;">
        Si usted no solicitó este código, puede ignorar este mensaje.
      </p>
    </div>
    
    <p style="text-align:center; font-size:12px; color:#bdc3c7; margin-top:30px;">
      &copy; 2025 Academix. Todos los derechos reservados.
    </p>
  </div>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'From: Academix <postmaster@localhost>' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
/*
// Cabeceras adicionales
$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$cabeceras .= 'From: Recordatorio <cumples@example.com>' . "\r\n";
$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
*/
// Enviarlo
$enviado =false;
if(mail($para, $título, $mensaje, $cabeceras)){
    $enviado=true;
}

?>