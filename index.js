//REGISTRO
const signUp = document.getElementById("sign-up");
const login = document.getElementById("log-in");
const recoverPassword = document.getElementById("recuperar-contraseña");
const password = document.getElementById("contraseña");
const passwordRpt = document.getElementById("contraseña-rpt");
const showPassword = document.getElementById("eye-slash");
const showPasswordRpt = document.getElementById("eye-slash-rpt");
const loginPwd = document.getElementById("login-pwd");
const inputsRegister = document.querySelectorAll(".inputs-register");
const inputsLogin = document.querySelectorAll(".inputs-login");

//Mostrando el login
function showLogin() {
  signUp.style.display = "none";
  login.style.display = "block";
  recoverPassword.style.display = "none";

  inputsRegister.forEach((input) => {
    input.value = "";
  });
}

//Dirigirse al componente de registro
function showRegister() {
  login.style.display = "none";
  signUp.style.display = "flex";

  inputsLogin.forEach((input) => {
    input.value = "";
  });
}

//Dirigirse al componente de recuperar contraseña
function showRecoverPass() {
  login.style.display = "none";
  recoverPassword.style.display = "flex";

  inputsLogin.forEach((input) => {
    input.value = "";
  });
}

//Mostrando contraseña sin ocultar
function revealPassword() {
  const isPassword = password.type == "password";

  password.type = isPassword ? "text" : "password";
  showPassword.classList.toggle("fa-eye");
  showPassword.classList.toggle("fa-eye-slash");
}

//Mostrando contraseña sin ocultar en login
function revealPasswordLogin() {
  const isPassword = loginPwd.type == "password";

  loginPwd.type = isPassword ? "text" : "password";
  showPassword.classList.toggle("fa-eye");
  showPassword.classList.toggle("fa-eye-slash");
}

//Mostrar la otra contraseña sin ocultar
function revealPasswordRpt() {
  const isPassword = passwordRpt.type == "password";

  passwordRpt.type = isPassword ? "text" : "password";
  showPasswordRpt.classList.toggle("fa-eye");
  showPasswordRpt.classList.toggle("fa-eye-slash");
}

//Cambio de fondo cada cierto tiempo
const backgroundImages = [
  "src/fondo2.webp",
  "src/fondo1.jpg",
  "src/fondo3.png",
];

let cont = 0;

function changeBackground() {
  document.body.style.backgroundImage = `url("${backgroundImages[cont]}")`;
  cont = (cont + 1) % backgroundImages.length;
}

setInterval(changeBackground, 3000);

window.onload = changeBackground;
