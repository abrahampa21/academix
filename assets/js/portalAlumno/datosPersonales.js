const pencil = document.querySelectorAll("i[data-input]");
//Poder editar los datos de la tabla
pencil.forEach((pen) => {
  pen.addEventListener("click", () => {
    const inputId = pen.getAttribute("data-input");
    const input = document.getElementById(inputId);
    if (input) {
      input.readOnly = false;
    }
  });
});

function confirmation(event) {
  const message = confirm("¿Realmente quieres modificar los datos?");
  if (!message) {
    event.preventDefault();
  }
}
AOS.init();
