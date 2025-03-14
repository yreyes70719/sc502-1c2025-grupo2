document.addEventListener("DOMContentLoaded", function () {
    //  lógica cuando el DOM esté completamente cargado
});

function redirectToHome(event) {
    event.preventDefault();
    window.location.href = 'home.html';
}