const passwordRpt = document.getElementById("password-rpt");
const password = document.getElementById("password-input");
const showPassword = document.getElementById("eye-slash");
const showPasswordRpt = document.getElementById("eye-slash-rpt");

//No dejar copiar los contenidos de las contraseñas
function bloquearCopiadoRegistro(password) {
  password.addEventListener("copy", (e) => e.preventDefault());
  password.addEventListener("contextmenu", (e) => e.preventDefault());
  password.addEventListener("keydown", (e) => {
    if (
      (e.ctrlKey || e.metaKey) &&
      ["c", "x", "a"].includes(e.key.toLowerCase())
    ) {
      e.preventDefault();
    }
  });
}

function bloquearCopiadoRegistroRpt(passwordRpt) {
  passwordRpt.addEventListener("copy", (e) => e.preventDefault());
  passwordRpt.addEventListener("contextmenu", (e) => e.preventDefault());
  passwordRpt.addEventListener("keydown", (e) => {
    if (
      (e.ctrlKey || e.metaKey) &&
      ["c", "x", "a"].includes(e.key.toLowerCase())
    ) {
      e.preventDefault();
    }
  });
}

//Mostrando contraseña sin ocultar
function revealPassword() {
  const isPassword = password.type == "password";
  password.type = isPassword ? "text" : "password";
  showPassword.classList.toggle("fa-eye");
  showPassword.classList.toggle("fa-eye-slash");

  if (isPassword) {
    bloquearCopiadoRegistro(password);
  }
}

function revealPasswordRpt() {
  const isPassword = passwordRpt.type == "password";
  passwordRpt.type = isPassword ? "text" : "password";
  showPasswordRpt.classList.toggle("fa-eye");
  showPasswordRpt.classList.toggle("fa-eye-slash");

  if (isPassword) {
    bloquearCopiadoRegistroRpt(passwordRpt);
  }
}
