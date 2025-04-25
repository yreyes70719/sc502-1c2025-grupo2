document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".menu-link");
    const contentContainer = document.getElementById("dynamic-content");

    links.forEach(link => {
        link.addEventListener("click", (event) => {
            event.preventDefault();

            // Obtener la página a cargar desde el atributo data-page
            const page = link.getAttribute("data-page");

            // Realizar una solicitud para cargar el contenido
            fetch(page)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Error al cargar la página");
                    }
                    return response.text();
                })
                .then(html => {
                    // Insertar el contenido en el contenedor dinámico
                    contentContainer.innerHTML = html;

                    // Actualizar la clase activa en el menú
                    links.forEach(l => l.classList.remove("active"));
                    link.classList.add("active");
                })
                .catch(error => {
                    console.error(error);
                    contentContainer.innerHTML = "<p>Error al cargar el contenido.</p>";
                });
        });
    });

    document.getElementById('logout-link').addEventListener('click', function (event) {
        event.preventDefault(); // Evitar la acción predeterminada del enlace
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se cerrará tu sesión actual.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir al controlador de logout
                window.location.href = 'app/controllers/LogoutController.php';
            }
        });
    });
});

function redirectToHome(event) {
    event.preventDefault();
    window.location.href = 'home.html';
}

