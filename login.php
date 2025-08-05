<?php
include("src/conexion.php");
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
        header("Location: portalAlumno.php");
    } elseif ($_SESSION['rol'] === 'prof') {
        header("Location: portalProfesor.php");
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
        $_SESSION['rol'] = 'alu';
        header("Location: portalAlumno.php");
        exit;
    }

    $sql2 = "SELECT matriculaP FROM profesor WHERE matriculaP = '$matricula' AND password = '$password_encriptada'";
    $resultado2 = $conexion->query($sql2);

    if ($resultado2->num_rows > 0) {
        $row2 = $resultado2->fetch_assoc();
        $_SESSION['id_matricula'] = $row2['matriculaP'];
        $_SESSION['rol'] = 'prof';
        header("Location: portalProfesor.php");
        exit;
    }

    echo "<script>
            alert('Error al iniciar sesión');
            window.location = 'login.php';
        </script>";
}

// Registrar
if (isset($_POST["registrar"])) {
    // Guardar lo que el usuario escribió
    $datosFormulario['nombre'] = $_POST['nombre'] ?? '';
    $datosFormulario['email'] = $_POST['email'] ?? '';
    $datosFormulario['matricula'] = $_POST['matricula'] ?? '';
    $datosFormulario['rol'] = $_POST['rol'] ?? '';

    // Validar formato de contraseña
    if (!preg_match('/^(?=.*[\W_])(?=.*[A-Za-z]).{10,}$/', $_POST['contraseña'])) {
        echo "<script>
            alert('La contraseña debe tener al menos 10 caracteres, letras y un carácter especial.');
        </script>";
        $mostrarRegistro = true;

        // Validar coincidencia de contraseñas
    } elseif ($password !== $passwordRpt) {
        echo "<script>
            alert('Las contraseñas no coinciden');
        </script>";
        $mostrarRegistro = true;

    } else {
        $alu_prof = $_POST["rol"];
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $correo = mysqli_real_escape_string($conexion, $_POST['email']);
        $matricula = mysqli_real_escape_string($conexion, $_POST['matricula']);
        $password = mysqli_real_escape_string($conexion, $_POST['contraseña']);
        $password_encriptada = sha1($password);

        $sqluser_alumno = "SELECT matriculaA FROM alumno WHERE matriculaA = '$matricula'";
        $sqluser_profesor = "SELECT matriculaP FROM profesor WHERE matriculaP = '$matricula'";
        $resultadouser_alumno = $conexion->query($sqluser_alumno);
        $resultadouser_profesor = $conexion->query($sqluser_profesor);

        if ($alu_prof == "alu") {
            $sqluser = "SELECT matriculaA FROM alumno WHERE matriculaA = '$matricula'";
            $resultadouser = $conexion->query($sqluser);

            if ($resultadouser->num_rows > 0 || $resultadouser_profesor->num_rows > 0) {
                echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'El usuario ya existe',
                        }).then(() => {
                            window.location = 'login.php';
                        });
                    });
                </script>";
            } else {
                $sqlusuario = "INSERT INTO alumno(nombreCompleto, email, matriculaA, password)
                    VALUES ('$nombre', '$correo', '$matricula', '$password_encriptada')";
                $resultadousuario = $conexion->query($sqlusuario);
                if ($resultadousuario > 0) {
                    echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire('¡Registro exitoso!').then(() => {
                                window.location = 'login.php';
                            });
                        });
                    </script>";
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                            icon: 'error',
                            text: 'Error al registrarse'
                            }).then(() => {
                                window.location = 'login.php';
                            });
                        });
                    </script>";
                }
            }
        } else if ($alu_prof == "prof") {
            $sqluser = "SELECT matriculaP FROM profesor WHERE matriculaP = '$matricula'";
            $resultadouser = $conexion->query($sqluser);

            if ($resultadouser->num_rows > 0 || $resultadouser_profesor->num_rows > 0) {
                echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'El usuario ya existe',
                        }).then(() => {
                            window.location = 'login.php';
                        });
                    });
                </script>";
            } else {
                $sqlusuario = "INSERT INTO profesor(nombreCompleto, email, matriculaP, password)
                    VALUES ('$nombre', '$correo', '$matricula', '$password_encriptada')";
                $resultadousuario = $conexion->query($sqlusuario);
                if ($resultadousuario > 0) {
                    echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire('¡Registro exitoso!').then(() => {
                                window.location = 'login.php';
                            });
                        });
                    </script>";
                } else {
                    echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                            icon: 'error',
                            text: 'Error al registrarse'
                            }).then(() => {
                                window.location = 'login.php';
                            });
                        })
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
    <link rel="stylesheet" href="assets/css/login.css?v=1.0">
    <link rel="icon" href="src/img/academix.jpg">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <script src="https://kit.fontawesome.com/e522357059.js" crossorigin="anonymous"></script>
    <title>Academix</title>
</head>

<body>

    <!--Inicio de sesión-->
    <form class="log-in" method="post" action="<?php $_SERVER["PHP_SELF"]; ?>" id="log-in" autocomplete="off" data-aos="fade-down" data-aos-duration="800">
        <div class="login-container">
            <h1>Inicio de Sesión</h1>
            <img src="src/img/academix.jpg" alt="Logo página">
            <div class="input-Usuario div-input matricula-div-login">
                <input type="text" name="matricula" class="inputs-login" placeholder="Matrícula" required>
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-Usuario div-input">
                <input type="password" name="pass" class="inputs-login" id="login-pwd" placeholder="Contraseña" required>
                <i class="fa-regular fa-eye-slash" id="login-pwd-icon" onclick="revealPasswordLogin()"></i>
            </div>

            <a href="#" class="forgot-pass" onclick="showRecoverPass()">Olvidé mi contraseña</a>

            <button type="submit" name="log" class="login-btn">Ingresar</button>

            <div class="create">
                <p class="create">¿No tienes una cuenta? <span class="btn-sign-up" id="btn-sign-up" onclick="showRegister()">Create una</span></p>
            </div>
        </div>
    </form>

    <!--Registro-->
    <form class="sign-up" id="sign-up" method="post" action="<?php $_SERVER["PHP_SELF"]; ?>" data-aos="fade-down" autocomplete="off">
        <i id="back" class="arrow fa-solid fa-arrow-left" title="Regresar" onclick="showLogin()"></i>
        <h1>Registro para el portal</h1>
        <div class="inputs">
            <div class="div-name div-input">
                <input type="text" name="nombre" class="inputs-register" placeholder="Nombre completo" id="nombre" required value="<?php echo $datosFormulario['nombre']?>">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="div-email div-input">
                <input type="email" name="email" class="inputs-register" placeholder="Correo electrónico" id="email" required value="<?php echo $datosFormulario['email']?>">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="div-user div-input">
                <input type="text" name="matricula" class="inputs-register" placeholder="Matrícula" id="matricula" required value="<?php echo $datosFormulario['matricula']?>">
                <i class="fa-solid fa-pen-nib"></i>
            </div>
            <div class="input-password div-input">
                <input type="password" name="contraseña" class="inputs-register" placeholder="Contraseña" id="contraseña" required>
                <i class="fa-regular fa-eye-slash" id="eye-slash" onclick="revealPassword()"></i>
            </div>
            <p id="passwordMessage" class="error"></p>
            <div class="input-password div-input">
                <input type="password" name="contraseña-rpt" class="inputs-register" placeholder="Repite la contraseña" id="contraseña-rpt" required>
                <i class="fa-regular fa-eye-slash" id="eye-slash-rpt" onclick="revealPasswordRpt()"></i>
            </div>
            <div class="checkbox">
                <div class="alumno-div div-checkboxes">
                    <input type="radio" placeholder="h" class="profesor checkboxes inputs-register" name="rol" id="profesor" value="prof" required <?= $datosFormulario['rol'] === 'prof' ? 'checked' : '' ?>>
                    <label for="profesor">Profesor</label>
                </div>
                <div class="profesor-div div-checkboxes">
                    <input type="radio" placeholder="h" class="alumno checkboxes inputs-register" name="rol" id="alumno" value="alu" required <?= $datosFormulario['rol'] === 'alu' ? 'checked' : '' ?>>
                    <label for="alumno">Alumno</label>
                </div>
            </div>
            <button type="submit" name="registrar">Registrar</button>
        </div>
        <p class="login-p">¿Ya tienes una cuenta? <span id="back-text" onclick="showLogin()">Ingresa aquí</span></p>
    </form>

    <!--Recuperar contraseña-->
    <form action="src/restablecerPHP.php" method="POST" class="recuperar-pass" id="recuperar-contraseña" data-aos="flip-right" autocomplete="off">
        <i id="back" class="arrow fa-solid fa-arrow-left" title="Regresar" onclick="showLogin()"></i>
        <h1>Recuperar contraseña</h1>
        <p>Ingresa tu correo electronico para recibir las instrucciones</p>
        <div class="input-button">
            <input type="email" name="email" required>
            <button type="submit">Enviar</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/login.js"></script>

    <?php if ($mostrarRegistro): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.log-in').style.display = 'none';
                document.querySelector('.sign-up').style.display = 'flex';
            });
        </script>
    <?php endif; ?>
    <script>
        AOS.init();
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById("contraseña");
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