document.addEventListener("DOMContentLoaded", function () {
    const dudasForm = document.getElementById("dudasForm");
    const successMessage = document.getElementById("successMessage");
    const errorMessage = document.getElementById("errorMessage");

    dudasForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        // Crear un objeto FormData con los datos del formulario
        const formData = new FormData(dudasForm);

        // Enviar los datos al controlador mediante fetch
        fetch("app/controllers/DudasController.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.error) {
                    // Mostrar mensaje de error
                    errorMessage.classList.remove("hidden");
                    successMessage.classList.add("hidden");
                    errorMessage.textContent = data.error;
                } else {
                    // Mostrar mensaje de éxito
                    successMessage.classList.remove("hidden");
                    errorMessage.classList.add("hidden");
                    successMessage.textContent = "Duda enviada correctamente.";
                    dudasForm.reset(); // Limpiar el formulario
                }
            })
            .catch((error) => {
                // Manejar errores de red u otros problemas
                errorMessage.classList.remove("hidden");
                successMessage.classList.add("hidden");
                errorMessage.textContent = "Ocurrió un error al enviar la duda. Por favor, inténtalo de nuevo.";
                console.error("Error:", error);
            });
    });
});