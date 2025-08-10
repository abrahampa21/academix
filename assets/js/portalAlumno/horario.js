AOS.init();
const btnModifiedSchedule = document.getElementById("btn-modified-schedule");

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
}

function guardarHorario() {
  const tabla = document.getElementById("horario");
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
