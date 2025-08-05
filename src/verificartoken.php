<?php
include "conexion.php";
$email = $_POST['email'];
$token = $_POST['token'];
$codigo = $_POST['codigo'];
$res = $conexion->query("select * from passwords where 
        email='$email' and token='$token' and codigo=$codigo") or die($conexion->error);
$correcto = false;
if (mysqli_num_rows($res) > 0) {
    $fila = mysqli_fetch_row($res);
    $fecha = $fila[4];
    $fecha_actual = date("Y-m-d h:m:s");
    $seconds = strtotime($fecha_actual) - strtotime($fecha);
    $minutos = $seconds / 60;
    /* if($minutos > 10 ){
            echo "token vencido";
        }else{
            echo "todo correcto";
        }*/
    $correcto = true;
} else {
    $correcto = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña </title>
    <!-- CSS only -->
    <link rel="stylesheet" href="../assets/css/recuperacion.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
    <script src="https://kit.fontawesome.com/e522357059.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center" style="margin-top:15%">
            <?php if ($correcto) { ?>
                <form class="col-3" action="./cambiarpassword.php" method="POST">
                    <h2>Restablecer Contraseña</h2>
                    <div class="mb-3">
                        <label for="c" class="form-label2">Escribe tu nueva contraseña</label>
                        <div class="input-password">
                            <input type="password" class="form-control password-input" id="password-input" name="p1">
                            <i class="fa-regular fa-eye-slash" id="eye-slash" onclick="revealPassword()"></i>
                        </div>
                        <p id="passwordMessage" class="error"></p>

                    </div>
                    <div class="mb-3">
                        <label for="c" class="form-label2">Confirmar la contraseña</label>
                        <div class="input-password">
                            <input type="password" class="form-control" id="password-rpt" name="p2">
                            <i class="fa-regular fa-eye-slash" id="eye-slash-rpt" onclick="revealPasswordRpt()"></i>
                        </div>
                        <input type="hidden" class="form-control password-rpt" id="c" name="email" value="<?php echo $email ?>">

                    </div>
                    <button type="submit" class="btn btn-primary">Cambiar</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-danger">Código incorrecto o vencido</div>
            <?php } ?>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="../assets/js/recuperacion.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById("password-input");
            const messageDiv = document.getElementById("passwordMessage");

            const regex = /^(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>/?])(?=.*[A-Za-z]).{10,}$/;

            if (passwordInput) {
                passwordInput.addEventListener("input", function() {
                    const value = passwordInput.value;

                    if (regex.test(value)) {
                        messageDiv.textContent = "Contraseña válida";
                        messageDiv.style.color = "green";
                        messageDiv.style.fontSize = "12px";
                    } else {
                        messageDiv.textContent = "Debe tener al menos 10 caracteres, letras y caractéres especiales";
                        messageDiv.style.color = "red";
                        messageDiv.style.fontSize = "12px";
                        messageDiv.style.width = "300px";

                    }
                });
            }

        });
    </script>
</body>

</html>