AOS.init();

function descargarPDF() {
  const tabla = document.getElementById("horario");
  const opciones = {
    margin: 0.5,
    filename: "horario.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };
  html2pdf().set(opciones).from(horario).save();
}
