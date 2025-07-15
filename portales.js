const dataStudent = document.getElementById("data-student");
const personalData = document.getElementById("personal-data");
const asistenciaTabla = document.getElementById("asistencia");
const asistenciaBtn = document.getElementById("asistencia-btn");
const horarioBtn = document.getElementById("horario-btn");
const horario = document.getElementById("horario");
const homeBtn = document.getElementById("home");
const main = document.getElementById("main");
//Pencils
const penDate = document.getElementById("pen-date");
const penDegree = document.getElementById("pen-degree");
const penPeriod = document.getElementById("pen-period");
const penStatus = document.getElementById("pen-status");
const penDirection = document.getElementById("pen-direction");

//Inputs
const inputDate = document.getElementById("fechaNac");
const inputCarrera = document.getElementById("carrera");
const inputPeriodo = document.getElementById("periodo");
const inputEstatus = document.getElementById("estatus");
const inputDireccion = document.getElementById("direccion");

penDate.addEventListener("click", () => {
    inputDate.readOnly = false;
})

penDegree.addEventListener("click", () => {
    inputCarrera.readOnly = false;
})

penPeriod.addEventListener("click", () => {
    inputPeriodo.readOnly = false;
})

penStatus.addEventListener("click", () => {
    inputEstatus.readOnly = false;
})

penDirection.addEventListener("click", () => {
    inputDireccion.readOnly = false;
})

//Mostrando los datos personales
dataStudent.addEventListener("click", (e) => {
    e.preventDefault();
    personalData.style.display = "block";
    main.style.display = "none";
    if(asistenciaTabla.style.display == "block" || horario.style.display == "block"){
        asistenciaTabla.style.display = "none";
        horario.style.display = "none";
    }
})

//Mostrando la tabla de asistencias
asistenciaBtn.addEventListener("click", (e) => {
    e.preventDefault();
    asistenciaTabla.style.display = "block";
    main.style.display = "none";
    if(horario.style.display == "block" || personalData.style.display == "block"){
        personalData.style.display = "none";
        horario.style.display = "none";
    }
})

//Mostrando el horario
horarioBtn.addEventListener("click", (e) => {
    e.preventDefault();
    horario.style.display = "block";
    main.style.display = "none";
    if(asistenciaTabla.style.display == "block" || personalData.style.display == "block"){
        asistenciaTabla.style.display = "none";
        personalData.style.display = "none";
    }
})

//Regresando al menú
homeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    main.style.display = "flex";
    if(asistenciaTabla.style.display == "block" || personalData.style.display == "block" || horario.style.display == "block"){
        asistenciaTabla.style.display = "none";
        personalData.style.display = "none";
        horario.style.display = "none";
    }
})

//Carrusel de imágenes de fondo
let current = 0;
const images = document.querySelectorAll('.img-bg');

  setInterval(() => {
    images[current].classList.remove('active');
    current = (current + 1) % images.length;
    images[current].classList.add('active');
  }, 4000);