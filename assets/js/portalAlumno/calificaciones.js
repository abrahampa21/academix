AOS.init();

function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
  document.getElementById("modalReporte").addEventListener("submit", (e) => {
  Swal.fire("Reporte enviado con exito");
  cerrarModal();
  })
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function returnMenu(){
  window.location.href = "portalAlumno.php";
}

function descargarPDF() {
  const tabla = document.getElementById("calificaciones");
  const opciones = {
    margin: 0.5,
    filename: "calificaciones.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };
  html2pdf().set(opciones).from(calificaciones).save();
}