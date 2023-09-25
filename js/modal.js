const botones = document.querySelectorAll(".button-info,.button-report");
const ventanas = document.querySelectorAll(".ventana");
const btnCerrarVentana = document.querySelectorAll('.cerrar-ventana');
const overlay = document.querySelectorAll('.overlay');
const botonesDescarga = document.querySelectorAll(".button-descargar");

const abrirVentana = function () {
    const index = Array.from(botones).indexOf(this);
    ventanas[index].classList.remove("oculta");
    overlay[index].classList.remove("oculta");
    };
const cerrarVentana = function () {
    const index = Array.from(btnCerrarVentana).indexOf(this);
    ventanas[index].classList.add("oculta");
    overlay[index].classList.add("oculta");
     };

botonesDescarga.forEach(button => {
    button.addEventListener('click', function (e) {
    e.preventDefault();
    window.open(this.getAttribute('href'), '_blank');
     });
});

botones.forEach(button => button.addEventListener('click', abrirVentana));
btnCerrarVentana.forEach(btnCerrar => btnCerrar.addEventListener("click", cerrarVentana));