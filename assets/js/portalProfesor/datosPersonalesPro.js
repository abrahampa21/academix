const pencilDate = document.getElementById("pen-date");
//Poder editar los datos de la tabla
pencilDate.addEventListener("click", () => {
  const input = document.getElementById("fechaNac");
  if (input) {
    input.readOnly = false;
  }
});

function confirmation(event) {
  const message = confirm("¿Realmente quieres modificar los datos?");
  if (!message) {
    event.preventDefault();
  }
}
AOS.init();
