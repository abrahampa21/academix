const btnModifiedSchedule = document.getElementById("btn-modified-schedule");


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

//Abrir y cerrar el modal del reporte
function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function agregarMateria() {
  const tabla = document.getElementById("horario").querySelector("tbody");

  const nuevaFila = document.createElement("tr");

  // Crea 9 celdas vacías (igual que el número de columnas)
  for (let i = 0; i < 9; i++) {
    const td = document.createElement("td");
    td.classList.add("asignatura");
    const input = document.createElement("input");
    input.type = "text";
    input.style.width = "100%";
    input.style.border = "1px solid #aaa";
    td.appendChild(input);
    nuevaFila.appendChild(td);
  }

  tabla.appendChild(nuevaFila);
}


function editarHorario() {
  const tabla = document.getElementById("horario");
  const filas = tabla.querySelectorAll("tbody tr");
  const addSubject = document.getElementById("add-subject");

  addSubject.style.display = "block";

  filas.forEach(fila => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach(td => {
      // Evitar duplicar inputs si ya está editando
      if (td.querySelector('input')) return;

      const valor = td.innerHTML.trim();
      const textoPlano = td.innerText.trim();

      const input = document.createElement("input");
      input.type = "text";
      input.value = textoPlano;
      input.style.width = "100%";
      input.style.border = "1px solid #aaa";

      td.innerHTML = "";
      td.appendChild(input);
    });
  });
}

function guardarHorario() {
  const tabla = document.getElementById("horario");
  const filas = tabla.querySelectorAll("tbody tr");

  filas.forEach(fila => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach(td => {
      const input = td.querySelector("input");
      if (input) {
        td.textContent = input.value.trim();
      }
    });
  });

  Swal.fire("Horario enviado", "Tus cambios han sido guardados.", "success");
}

//Función para preguntar si tiene autorización de cambios
function authorized() {
  Swal.fire({
    title: "¿Ya te autorizaron los cambios?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Sí",
    denyButtonText: `No`,
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Autorizado!", "", "success");
      btnModifiedSchedule.setAttribute("onclick","guardarHorario()");
      editarHorario();
    } else if (result.isDenied) {
      Swal.fire("No tienes permiso de modificar");
    }
  });
}

function returnMenuAlu(){
  window.location.href = "../portalAlumno.php";
}

function returnMenuProf(){
  window.location.href = "../portalProfesor.php";
}