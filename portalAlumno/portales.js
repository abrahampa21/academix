const pencil = document.querySelectorAll("i[data-input]");

pencil.forEach((pen) => {
  pen.addEventListener("click", () => {
    const inputId = pen.getAttribute("data-input");
    const input = document.getElementById(inputId);
    if (input) {
      input.readOnly = false;
    }
  });
});

AOS.init();
