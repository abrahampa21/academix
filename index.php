<?php
include("conexion.php");
session_start();

$mostrarRegistro = false;
$datosFormulario = [
    'nombre' => '',
    'email' => '',
    'matricula' => '',
    'rol' => '',
];

// Si ya está logueado, redirige
if (isset($_SESSION['id_usuario'])) {
    if ($_SESSION['rol'] === 'alu') {
        header("Location: portalAlumno.html");
    } elseif ($_SESSION['rol'] === 'prof') {
        header("Location: portalProfesor.html");
    }
    exit;
}

// Login
if (isset($_POST["log"])) {
    $matricula = mysqli_real_escape_string($conexion, $_POST['matricula']);
    $password = mysqli_real_escape_string($conexion, $_POST['pass']);
    $password_encriptada = sha1($password);

    $sql = "SELECT matriculaA FROM alumno WHERE matriculaA = '$matricula' AND password = '$password_encriptada'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $_SESSION['id_matricula'] = $row['matriculaA'];
        header("Location: portalAlumno.html");
        exit;
    }

    $sql2 = "SELECT matriculaP FROM profesor WHERE matriculaP = '$matricula' AND password = '$password_encriptada'";
    $resultado2 = $conexion->query($sql2);

    if ($resultado2->num_rows > 0) {
        $row2 = $resultado2->fetch_assoc();
        $_SESSION['id_matricula'] = $row2['matriculaP'];
        header("Location: portalProfesor.html");
        exit;
    }

    echo "<script>
            alert('Usuario o contraseña incorrecta');
            window.location = 'index.php';
        </script>";
}

// Registrar
if (isset($_POST["registrar"])) {
    // Guardar lo que el usuario escribió
    $datosFormulario['nombre'] = $_POST['nombre'] ?? '';
    $datosFormulario['email'] = $_POST['email'] ?? '';
    $datosFormulario['matricula'] = $_POST['matricula'] ?? '';
    $datosFormulario['rol'] = $_POST['rol'] ?? '';

    if (
        isset($_POST['contraseña'], $_POST['contraseña-rpt']) &&
        $_POST['contraseña'] !== $_POST['contraseña-rpt']
    ) {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
        $mostrarRegistro = true;
    } else if (isset($_POST["rol"])) {
        $alu_prof = $_POST["rol"];
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo = mysqli_real_escape_string($conexion, $_POST['email']);
        $matricula = mysqli_real_escape_string($conexion, $_POST['matricula']);
        $password = mysqli_real_escape_string($conexion, $_POST['contraseña']);
        $password_encriptada = sha1($password);

        if ($alu_prof == "alu") {
            $sqluser = "SELECT matriculaA FROM alumno WHERE matriculaA = '$matricula'";
            $resultadouser = $conexion->query($sqluser);

            if ($resultadouser->num_rows > 0) {
                echo "<script>
                    alert('El usuario ya existe');
                    window.location = 'index.php';
                </script>";
            } else {
                $sqlusuario = "INSERT INTO alumno(nombreCompleto, email, matriculaA, password)
                    VALUES ('$nombre', '$correo', '$matricula', '$password_encriptada')";
                $resultadousuario = $conexion->query($sqlusuario);
                if ($resultadousuario > 0) {
                    echo "<script>
                        alert('Registro Exitoso');
                        window.location = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Error al registrarse');
                        window.location = 'index.php';
                    </script>";
                }
            }
        } else if ($alu_prof == "prof") {
            $sqluser = "SELECT matriculaP FROM profesor WHERE matriculaP = '$matricula'";
            $resultadouser = $conexion->query($sqluser);

            if ($resultadouser->num_rows > 0) {
                echo "<script>
                    alert('El usuario ya existe');
                    window.location = 'index.php';
                </script>";
            } else {
                $sqlusuario = "INSERT INTO profesor(nombreCompleto, email, matriculaP, password)
                    VALUES ('$nombre', '$correo', '$matricula', '$password_encriptada')";
                $resultadousuario = $conexion->query($sqlusuario);
                if ($resultadousuario > 0) {
                    echo "<script>
                        alert('Registro Exitoso');
                        window.location = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Error al registrarse');
                        window.location = 'index.php';
                    </script>";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="src/academix.jpg">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <title>Academix</title>
</head>

<body>

    <!--Inicio de sesión-->
    <form class="log-in" method="post" action="<?php $_SERVER["PHP_SELF"]; ?>" id="log-in" autocomplete="off" data-aos="fade-down">
        <div class="login-container">
            <h1>Inicio de Sesión</h1>
            <img src="src/academix.jpg" alt="Logo página">
            <div class="input-Usuario div-input matricula-div-login">
                <input type="text" name="matricula" class="inputs-register" placeholder="Matrícula" required>
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-Usuario div-input">
                <input type="password" name="pass" class="inputs-register" id="login-pwd" placeholder="Contraseña" required>
                <i class="fa-regular fa-eye-slash" id="login-pwd-icon" onclick="revealPasswordLogin()"></i>
            </div>

            <button type="submit" name="log" class="login-btn">Ingresar</button>

            <div class="create">
                <p class="create">¿No tienes una cuenta? <span class="btn-sign-up" id="btn-sign-up" onclick="showRegister()">Create una</span></p>
            </div>
        </div>
    </form>

    <!--Registro-->
    <form class="sign-up" id="sign-up" method="post" action="<?php $_SERVER["PHP_SELF"]; ?>" autocomplete="off">
        <i id="back" class="arrow fa-solid fa-arrow-left" title="Regresar" onclick="showLogin()"></i>
        <h1>Registro para el portal</h1>
        <div class="inputs">
            <div class="div-name div-input">
                <input type="text" name="nombre" class="inputs-register" placeholder="Nombre completo" id="nombre" required>
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="div-email div-input">
                <input type="email" name="email" class="inputs-register" placeholder="Correo electrónico" id="email" required>
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="div-user div-input">
                <input type="text" name="matricula" class="inputs-register" placeholder="Matrícula" id="matricula" required>
                <i class="fa-solid fa-pen-nib"></i>
            </div>
            <div class="input-password div-input">
                <input type="password" name="contraseña" class="inputs-register" placeholder="Contraseña" id="contraseña" required>
                <i class="fa-regular fa-eye-slash" id="eye-slash" onclick="revealPassword()"></i>
            </div>
            <div class="input-password div-input">
                <input type="password" name="contraseña-rpt" class="inputs-register" placeholder="Repite la contraseña" id="contraseña-rpt" required>
                <i class="fa-regular fa-eye-slash" id="eye-slash-rpt" onclick="revealPasswordRpt()"></i>
            </div>
            <div class="checkbox">
                <div class="alumno-div div-checkboxes">
                    <input type="radio" placeholder="h" class="profesor checkboxes inputs-register" name="rol" id="profesor" value="prof" required>
                    <label for="profesor">Profesor</label>
                </div>
                <div class="profesor-div div-checkboxes">
                    <input type="radio" placeholder="h" class="alumno checkboxes inputs-register" name="rol" id="alumno" value="alu" required>
                    <label for="alumno">Alumno</label>
                </div>
            </div>
            <button type="submit" name="registrar">Registrar</button>
        </div>
        <p class="login-p">¿Ya tienes una cuenta? <span id="back-text" onclick="showLogin()">Ingresa aquí</span></p>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/e522357059.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>

    <?php if ($mostrarRegistro): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.log-in').style.display = 'none';
                document.querySelector('.sign-up').style.display = 'flex';
            });
        </script>
    <?php endif; ?>
</body>

</html>