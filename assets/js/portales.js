const pencil = document.querySelectorAll("i[data-input]");
const btnTop = document.getElementById("scrollTopBtn");
const toggle = document.getElementById("toggle");
const menu = document.getElementById("menu");
const bar = document.getElementById("bars");

document.addEventListener("DOMContentLoaded", () =>{
  btnTop.style.display = "none";
})

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

window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  const triggerElement = document.getElementById("about-us");

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


AOS.init();
