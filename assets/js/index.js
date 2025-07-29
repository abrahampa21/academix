//Definiendo funciones
const toggle = document.getElementById("toggle");
const menu = document.getElementById("menu");
const bar = document.getElementById("bars");


AOS.init();

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
