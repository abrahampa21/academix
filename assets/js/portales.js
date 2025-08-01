//Variables principales
const btnTop = document.getElementById("scrollTopBtn");
const toggle = document.getElementById("toggle");
const menu = document.getElementById("menu");
const bar = document.getElementById("bars");

//Inicializando las animaciones
AOS.init();

document.addEventListener("DOMContentLoaded", () => {
  btnTop.style.display = "none";
});

//Función para que aparezca el botón de volver al top de la página
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  const triggerElement = document.getElementById("focus");

  if (triggerElement.getBoundingClientRect().top < window.innerHeight / 2) {
    btnTop.style.display = "block";
  } else {
    btnTop.style.display = "none";
  }
}

// Función para volver arriba
document.getElementById("scrollTopBtn").addEventListener("click", function () {
  window.scrollTo({ top: 0, behavior: "smooth" });
});


//Mostrar el menú con la responsividad
toggle.addEventListener("click", () => {
  menu.classList.toggle("menu-open");
  const barOpen = menu.classList.contains("menu-open");

  bar.classList = barOpen ? "fa-solid fa-xmark" : "fa-solid fa-bars";
});

//Función para confirmar salida
function exit() {
  const message = confirm("¿Realmente quieres salir del sitio?");

  if (message) {
    window.location.href = "http://localhost/academix/index.html";
  }
}
