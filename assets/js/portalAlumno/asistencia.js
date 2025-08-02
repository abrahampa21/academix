const asistenciasAlumno = document.getElementById("asistencias-alumno"); 
const asistenciasProfesor = document.getElementById("asistencias-profesor");

AOS.init();

function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
  document.getElementById("modalReporte").addEventListener("submit", (e) => {
    e.preventDefault();
    Swal.fire("Reporte enviado exitosamente");
    cerrarModal();
  })
}

function cerrarModal(){
  document.getElementById("modalReporte").style.display = "none";
}
