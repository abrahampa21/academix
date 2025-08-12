const meses = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

const pagos = {};
meses.forEach((mes, index) => {
  if (index <= 6) {
    pagos[mes] = { pagado: true, monto: 1672, beca: true };
  } else {
    pagos[mes] = { pagado: false };
  }
});

const tablaPagos = document.getElementById("tablaPagos");
const advertencia = document.getElementById("advertenciaPago");
const advertenciaDos = document.getElementById("advertenciaSegundoPago");

const fecha = new Date();
const mesActualNombre = fecha.toLocaleString("es-ES", { month: "long" });
const dia = fecha.getDate();

const mesCapitalizado =
  mesActualNombre.charAt(0).toUpperCase() +
  mesActualNombre.slice(1).toLowerCase();

// Rellenando la tabla
Object.entries(pagos).forEach(([mes, info]) => {
  const tr = document.createElement("tr");
  const estadoTexto = info.pagado ? "Pagado" : "Pendiente";
  const estadoColor = info.pagado ? "green" : "red";
  const montoTexto = info.pagado
    ? `$${info.monto} ${info.beca ? "(con beca)" : ""}`
    : "-";
  tr.innerHTML = `
        <td>${mes}</td>
        <td style="color:${estadoColor}">${estadoTexto}</td>
        <td>${montoTexto}</td>
      `;
  tablaPagos.appendChild(tr);
});

// Mostrar advertencia si no ha pagado este mes y estamos entre el 11 y el 31
if (
  pagos[mesCapitalizado] &&
  !pagos[mesCapitalizado].pagado &&
  dia >= 1 &&
  dia <= 10
) {
  advertencia.style.display = "block";
}

// Mostrar advertencia si no ha pagado este mes y estamos entre el 11 y el 31
if (
  pagos[mesCapitalizado] &&
  !pagos[mesCapitalizado].pagado &&
  dia >= 11 &&
  dia <= 31
) {
  advertenciaDos.style.display = "block";
}


function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
  document.getElementById("modalReporte").addEventListener("submit", (e) => {
  cerrarModal();
  })
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function returnMenu(){
  window.location.href = "../portalAlumno.php";
}