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
  window.location.href = "../portalAlumno.php";
}