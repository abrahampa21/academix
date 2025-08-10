AOS.init();
const btnModifiedSchedule = document.getElementById("btn-modified-schedule");

// clave de almacenamiento (por página)
const STORAGE_KEY = 'horario_saved_' + window.location.pathname;

// Carga al iniciar
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
  // Cada input que exista dentro del tbody actualizará su atributo value
  // y guardará el tbody en localStorage en cada cambio.
  const inputs = document.querySelectorAll("#horario tbody input");
  inputs.forEach((inp) => {
    // Aseguramos que el atributo value refleje el valor actual
    inp.setAttribute("value", inp.value || "");
    // Evitamos múltiples listeners duplicados borrando antes
    inp.removeEventListener("__horario_input_listener__", noop);
    const listener = () => {
      inp.setAttribute("value", inp.value);
      saveHorarioToLocal();
    };
    // Guardamos la referencia para evitar duplicados (no estándar pero práctico)
    inp.addEventListener("input", listener);
  });
}

function noop() {}

// Carga desde localStorage y vuelve a enganchar listeners
function loadSavedHorario() {
  const tbody = document.querySelector("#horario tbody");
  if (!tbody) return;
  const saved = localStorage.getItem(STORAGE_KEY);
  if (saved) {
    tbody.innerHTML = saved;
    // después de insertar el HTML restaurado, enganchamos listeners a inputs (si hay)
    attachInputListeners();
  }
}

// (opcional) borrar el guardado local
function clearSavedHorario() {
  localStorage.removeItem(STORAGE_KEY);
}

// ---------- Funciones originales con pequeñas integraciones para localStorage ----------

function descargarPDF() {
  const tabla = document.getElementById("horario");
  const opciones = {
    margin: 0.5,
    filename: "horario.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };
  // Dejo esta línea igual a la tuya para no alterar lo que ya tenías:
  html2pdf().set(opciones).from(horario).save();
}

function abrirModal() {
  document.getElementById("modalReporte").style.display = "flex";
  document.getElementById("modalReporte").addEventListener("submit", (e) => {
    cerrarModal();
  });
}

function cerrarModal() {
  document.getElementById("modalReporte").style.display = "none";
}

function editarHorario() {
  const tabla = document.getElementById("horario");
  const filas = tabla.querySelectorAll("tbody tr");

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach((td) => {
      // Evita duplicar inputs si ya está editando
      if (td.querySelector("input")) return;

      const spanProfesor = td.querySelector("span.profesor");

      if (spanProfesor) {
        const nombreProfesor = spanProfesor.innerText.trim();

        const contenidoMateria = td.innerHTML.split("<br")[0].trim();

        const inputMateria = document.createElement("input");
        inputMateria.type = "text";
        inputMateria.value = contenidoMateria;
        inputMateria.style.width = "100%";
        inputMateria.style.marginBottom = "5px";
        inputMateria.classList.add("input-materia");

        const inputProfesor = document.createElement("input");
        inputProfesor.type = "text";
        inputProfesor.value = nombreProfesor;
        inputProfesor.style.width = "100%";
        inputProfesor.classList.add("input-profesor");

        td.innerHTML = "";
        td.appendChild(inputMateria);
        td.appendChild(document.createElement("br"));
        td.appendChild(inputProfesor);
      } else {
        const textoPlano = td.innerText.trim();

        const input = document.createElement("input");
        input.type = "text";
        input.value = textoPlano;
        input.style.width = "100%";
        input.style.border = "1px solid #aaa";

        td.innerHTML = "";
        td.appendChild(input);
      }
    });
  });

  // Después de crear inputs, enganchamos listeners para autosalvar los cambios
  attachInputListeners();
  // Guardamos la estructura con inputs en localStorage (para preservarla si se va la página)
  saveHorarioToLocal();
}

function guardarHorario() {
  const tabla = document.getElementById("horario");
  const tbody = tabla.querySelector("tbody");

  // Primero: convertir inputs a texto (igual que antes)
  const filas = tabla.querySelectorAll("tbody tr");
  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach((td) => {
      const inputMateria = td.querySelector(".input-materia");
      const inputProfesor = td.querySelector(".input-profesor");

      if (inputMateria && inputProfesor) {
        const materia = inputMateria.value.trim();
        const profesor = inputProfesor.value.trim();

        td.innerHTML = `${materia}<br /><span class="profesor">${profesor}</span>`;
      } else {
        const input = td.querySelector("input");
        if (input) {
          td.textContent = input.value.trim();
        }
      }
    });
  });

  // Guardamos la versión visual final en localStorage para que se mantenga al volver
  saveHorarioToLocal();

  // En este punto el DOM ya contiene el horario modificado (visual)
  // Opciones para html2pdf (las mismas que ya usas)
  const opciones = {
    margin: 0.5,
    filename: "horario.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
  };

  // Generar PDF y enviarlo al servidor (no recargamos la página)
  html2pdf()
    .set(opciones)
    .from(tabla)
    .toPdf()
    .get("pdf")
    .then(function (pdf) {
      // Si quieres que además el usuario descargue el PDF, descomenta la línea siguiente:
      // pdf.save("horario.pdf");

      const blob = pdf.output("blob");
      const formData = new FormData();
      formData.append("action", "save_pdf");
      formData.append("pdf", blob, "horario.pdf");

      fetch("horario.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            Swal.fire("Horario enviado", "El PDF del horario se guardó en la base de datos.", "success");
            // NO recargamos la página: los cambios visuales se quedan
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
    } else if (result.isDenied) {
      Swal.fire("No tienes permiso de modificar");
    }
  });
}

function returnMenu() {
  window.location.href = "../portalAlumno.php";
}
