//REGISTRO
const arrowBack = document.getElementById("back");
const backTest = document.getElementById("back-text");
const signUp = document.getElementById("sign-up");
const login = document.getElementById("log-in");
const password = document.getElementById("contraseña");
const passwordRpt = document.getElementById("contraseña-rpt");
const showPassword = document.getElementById("eye-slash");
const showPasswordRpt = document.getElementById("eye-slash-rpt");
const btnSignUp = document.getElementById("btn-sign-up");
const loginPwd = document.getElementById("login-pwd")
const loginIcon = document.getElementById("login-pwd-icon")

//Show components login and sign up
arrowBack.addEventListener("click", () => {
  signUp.style.display = "none";
  login.style.display = "block";
});

backTest.addEventListener("click", () => {
  signUp.style.display = "none";
  login.style.display = "block";
});

//Show original password
showPassword.addEventListener("click", () => {
  const isPassword = password.type == "password";

  password.type = isPassword ? "text" : "password";
  showPassword.classList.toggle("fa-eye");
  showPassword.classList.toggle("fa-eye-slash");
});

//Show repeat password
showPasswordRpt.addEventListener("click", () => {
  const isPassword = passwordRpt.type == "password";

  passwordRpt.type = isPassword ? "text" : "password";
  showPasswordRpt.classList.toggle("fa-eye");
  showPasswordRpt.classList.toggle("fa-eye-slash");
});

//Show password in login
loginIcon.addEventListener("click", () => {
  const isPassword = loginPwd.type == "password";

  loginPwd.type = isPassword ? "text" : "password";
  loginIcon.classList.toggle("fa-eye");
  loginIcon.classList.toggle("fa-eye-slash");
})

//Dirigirse al componente de registro
btnSignUp.addEventListener("click", () => {
  login.style.display = "none";
  signUp.style.display = "flex";
})

//Animación
AOS.init({
  once: true,
});
