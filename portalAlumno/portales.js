const dataStudent = document.getElementById("data-student");
const personalData = document.getElementById("personal-data");
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



//Carrusel de imágenes de fondo
let current = 0;
const images = document.querySelectorAll('.img-bg');

  setInterval(() => {
    images[current].classList.remove('active');
    current = (current + 1) % images.length;
    images[current].classList.add('active');
  }, 4000);

AOS.init();