function modificar(e) {
  e.preventDefault();
  const form = document.getElementById("personal-data");
  const inputs = form.querySelectorAll("input, select");

  inputs.forEach((element) => {
    if (element.tagName === "INPUT") {
      element.removeAttribute("readonly");
    } else if (element.tagName === "SELECT") {
      element.removeAttribute("disabled");
    }
  });
}


function confirmation(event) {
  const message = confirm("¿Realmente quieres modificar los datos?");
  if (!message) {
    event.preventDefault();
  }
}

function returnMenu(){
  window.location.href = "/portalAlumno.php";
}

AOS.init();
