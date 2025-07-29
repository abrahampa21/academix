const asistenciasAlumno = document.getElementById("asistencias-alumno"); 
const asistenciasProfesor = document.getElementById("asistencias-profesor");

AOS.init();

//Agregando el objeto window para que reconoza las funciones
function abrirModal(){
  document.getElementById("modalReporte").style.display = "flex";
}

function cerrarModal(){
  document.getElementById("modalReporte").style.display = "none";
}
