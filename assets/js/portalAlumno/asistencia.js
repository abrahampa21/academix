const asistenciasAlumno = document.getElementById("asistencias-alumno"); 
const asistenciasProfesor = document.getElementById("asistencias-profesor");

AOS.init();

function abrirModal(){
  document.getElementById("modalReporte").style.display = "flex";
}

function cerrarModal(){
  document.getElementById("modalReporte").style.display = "none";
}
