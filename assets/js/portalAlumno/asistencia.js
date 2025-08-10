const asistenciasAlumno = document.getElementById("asistencias-alumno");
const asistenciasProfesor = document.getElementById("asistencias-profesor");

AOS.init();

function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
  document.getElementById("modalReporte").addEventListener("submit", (e) => {
    cerrarModal();
  });
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function returnMenu() {
  window.location.href = "../portalAlumno.php";
}

function descargarPDF() {
  const tabla = document.getElementById("asistencia");
  const opciones = {
    margin: 0.5,
    filename: "asistencia.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };
  html2pdf().set(opciones).from(asistencia).save();
}
