const btnModifiedStudents = document.getElementById("btn-modified-students");

function returnMenu(){
  window.location.href = "../portalProfesor.php";
}

function editarAlumnos() {
  const tabla = document.getElementById("alumnos");
  const filas = tabla.querySelectorAll("tbody tr");

  filas.forEach((fila) => {
    const celdas = fila.querySelectorAll("td");

    celdas.forEach((td) => {
      // Saltar celdas que contienen un enlace <a>
      if (td.querySelector("a")) return;

      // Evitar duplicar inputs si ya está editando
      if (td.querySelector("input")) return;

      const textoPlano = td.innerText.trim();

      const input = document.createElement("input");
      input.type = "text";
      input.value = textoPlano;
      input.style.width = "80%";
      input.style.border = "1px solid #aaa";

      td.innerHTML = "";
      td.appendChild(input);
    });
  });
}

function guardarAlumnos() {
  const tabla = document.getElementById("alumnos");
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
      btnModifiedStudents.setAttribute("onclick", "guardarAlumnos()");
      editarAlumnos();
    } else if (result.isDenied) {
      Swal.fire("No tienes permiso de modificar");
    }
  });
}

AOS.init();