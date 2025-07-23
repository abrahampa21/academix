AOS.init();

function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function verDetalles(mes) {
  alert(
    "Detalles de deducciones y percepciones para: " +
      mes +
      "\n- Percepciones: $20,000\n- Deducciones: $1,500"
  );
}

// Filtro por año y mes
const filtroAño = document.getElementById("filtroAño");
const filtroMes = document.getElementById("filtroMes");

filtroAño.addEventListener("change", filtrarTabla);
filtroMes.addEventListener("change", filtrarTabla);

function filtrarTabla() {
  const año = document.getElementById("filtroAño").value;
  const mes = document.getElementById("filtroMes").value;
  const filas = document.querySelectorAll("#tablaNomina tbody tr");

  filas.forEach((fila) => {
    const filaAño = fila.getAttribute("data-anio");
    const filaMes = fila.getAttribute("data-mes");
    const visible =
      (año === "todos" || filaAño === año) &&
      (mes === "todos" || filaMes === mes);
    fila.style.display = visible ? "" : "none";
  });
}
