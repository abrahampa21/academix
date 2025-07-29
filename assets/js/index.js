//Definiendo funciones
const btnTop = document.getElementById("scrollTopBtn");
const toggle = document.getElementById("toggle");
const menu = document.getElementById("menu");
const bar = document.getElementById("bars");

AOS.init();

document.addEventListener("DOMContentLoaded", () => {
  btnTop.style.display = "none";
});

//Función para que aparezca el botón de volver al top de la página
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  const triggerElement = document.getElementById("lic-content");

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

//Función para el carrusel
$(document).ready(function () {
  $(".carousel").slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: false,
    cssEase: "linear",
    prevArrow: '<button type="button" class="slick-prev">&#8592;</button>',
    nextArrow: '<button type="button" class="slick-next">&#8594;</button>',
  });
});

//Mostrar el menú con la responsividad
toggle.addEventListener("click", () => {
  menu.classList.toggle("menu-open");
  const barOpen = menu.classList.contains("menu-open");

  bar.classList = barOpen ? "fa-solid fa-xmark" : "fa-solid fa-bars";
});
