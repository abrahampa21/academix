const btnModifiedSchedule = document.getElementById("btn-modified-schedule");

AOS.init();

//Descargar la tabla en formato .pdf
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

//Genera una nueva materia
function agregarMateria() {
  const tabla = document.getElementById("horario").querySelector("tbody");
  const nuevaFila = document.createElement("tr");

  const placeholders = [
    "Asignatura",
    "Clave",
    "Salón",
    "Horas/Semana",
    "Lunes",
    "Martes",
    "Miércoles",
    "Jueves",
    "Viernes",
  ];

  for (let i = 0; i < 9; i++) {
    const td = document.createElement("td");

    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = placeholders[i];
    input.style.width = "100%";
    input.style.border = "1px solid #aaa";

    if(i == 0){
      td.classList.add("asignatura");
    }
    td.appendChild(input);
    nuevaFila.appendChild(td);
  }


  tabla.appendChild(nuevaFila);
}

//Función para editar los campos de la fila
function editarHorario() {
  const tabla = document.getElementById("horario");
  const filas = tabla.querySelectorAll("tbody tr");
  const crudButtons = document.getElementById("crud");

  crudButtons.style.display = "flex";

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach((td) => {
      // Evitar duplicar inputs si ya está editando
      if (td.querySelector("input")) return;

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

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach((td) => {
      const input = td.querySelector("input");
      if (input) {
        td.textContent = input.value.trim();
      }
    });
  });

  Swal.fire("Horario enviado", "Tus cambios han sido guardados.", "success");
}

//Eliminan las materias
function eliminarMateria() {
  let filaSeleccionada = null;
  const filas = document.querySelectorAll("#horario tbody tr");

  filas.forEach((fila) => {
    fila.addEventListener("click", (e) => {
      // Evitar seleccionar si se hizo clic en un input
      if (e.target.tagName === "INPUT") return;

      if (filaSeleccionada) {
        filaSeleccionada.classList.remove("selected");
      }

      filaSeleccionada = fila;
      fila.classList.add("selected");
    });
  });

  document.getElementById("delete-subject").addEventListener("click", () => {
    if (filaSeleccionada) {
      filaSeleccionada.remove();
      filaSeleccionada = null;
    } else {
      Swal.fire("Selecciona una fila primero");
    }
  });
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
      btnModifiedSchedule.setAttribute("onclick", "guardarHorario()");
      editarHorario();
      eliminarMateria();
    } else if (result.isDenied) {
      Swal.fire("No tienes permiso de modificar");
    }
  });
}

//Funciones para volver al menú en notificaciones
function returnMenuAlu() {
  window.location.href = "../portalAlumno.php";
}

function returnMenuProf() {
  window.location.href = "../portalProfesor.php";
}
