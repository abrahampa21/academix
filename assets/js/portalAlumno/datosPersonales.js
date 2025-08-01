const pencil = document.querySelectorAll("i[data-input]");

//Poder editar los datos de la tabla
pencil.forEach((pen) => {
  pen.addEventListener("click", () => {
    const inputId = pen.getAttribute("data-input");
    const element = document.getElementById(inputId);

    if (!element) return;

    if (element.tagName === "SELECT") {
      element.disabled = false; 
    } else if (element.tagName === "INPUT") {
      element.readOnly = false; 
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
