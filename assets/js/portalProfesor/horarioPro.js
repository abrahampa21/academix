const btnModifiedSchedule = document.getElementById("btn-modified-schedule");
AOS.init();

// Clave de almacenamiento única por página
const STORAGE_KEY = "horario_prof_saved_" + window.location.pathname;

// Cargar contenido guardado al entrar
document.addEventListener("DOMContentLoaded", () => {
  loadSavedHorario();
});

// ---------- LocalStorage helpers ----------
function saveHorarioToLocal() {
  const tbody = document.querySelector("#horario tbody");
  if (!tbody) return;
  localStorage.setItem(STORAGE_KEY, tbody.innerHTML);
}

function attachInputListeners() {
  const inputs = document.querySelectorAll("#horario tbody input");
  inputs.forEach((inp) => {
    inp.setAttribute("value", inp.value || "");
    inp.addEventListener("input", () => {
      inp.setAttribute("value", inp.value);
      saveHorarioToLocal();
    });
  });
}

function loadSavedHorario() {
  const tbody = document.querySelector("#horario tbody");
  if (!tbody) return;
  const saved = localStorage.getItem(STORAGE_KEY);
  if (saved) {
    tbody.innerHTML = saved;
    attachInputListeners();
  }
}

function clearSavedHorario() {
  localStorage.removeItem(STORAGE_KEY);
}

// ---------- Funciones originales ----------

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

    if (i == 0) td.classList.add("asignatura");
    td.appendChild(input);
    nuevaFila.appendChild(td);
  }

  tabla.appendChild(nuevaFila);
  attachInputListeners();
  saveHorarioToLocal();
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
      if (td.querySelector("input")) return;
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

  attachInputListeners();
  saveHorarioToLocal();
}

//Guardar horario y enviar PDF al servidor
function guardarHorario() {
  const tabla = document.getElementById("horario");
  const filas = tabla.querySelectorAll("tbody tr");

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");
    celdas.forEach((td) => {
      const input = td.querySelector("input");
      if (input) td.textContent = input.value.trim();
    });
  });

  saveHorarioToLocal();

  const opciones = {
    margin: 0.5,
    filename: "horario.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };

  html2pdf()
    .set(opciones)
    .from(tabla)
    .toPdf()
    .get("pdf")
    .then(function (pdf) {
      const blob = pdf.output("blob");
      const formData = new FormData();
      formData.append("action", "save_pdf");
      formData.append("pdf", blob, "horario.pdf");

      fetch("horarioPro.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            Swal.fire("Horario enviado", "El PDF del horario se guardó en la base de datos.", "success");
          } else {
            Swal.fire("Error", data.error || "No se pudo guardar el PDF en la BD.", "error");
            console.error("Guardar PDF error:", data);
          }
        })
        .catch((err) => {
          console.error("Fetch error:", err);
          Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
        });
    });
}

//Eliminan las materias
function eliminarMateria() {
  let filaSeleccionada = null;
  const filas = document.querySelectorAll("#horario tbody tr");

  filas.forEach((fila) => {
    fila.addEventListener("click", (e) => {
      if (e.target.tagName === "INPUT") return;

      if (filaSeleccionada) filaSeleccionada.classList.remove("selected");

      filaSeleccionada = fila;
      fila.classList.add("selected");
    });
  });

  document.getElementById("delete-subject").addEventListener("click", () => {
    if (filaSeleccionada) {
      filaSeleccionada.remove();
      filaSeleccionada = null;
      saveHorarioToLocal();
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

//Funciones para volver al menú
function returnMenuAlu() {
  window.location.href = "../portalAlumno.php";
}

function returnMenuProf() {
  window.location.href = "../portalProfesor.php";
}
