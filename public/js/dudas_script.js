document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("tbody");

    // Delegación de eventos para manejar el clic en botones de eliminar
    tableBody.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-btn")) {
            const idDuda = event.target.dataset.id;

            if (confirm("¿Estás seguro de que deseas eliminar esta duda?")) {
                // Enviar solicitud para eliminar la duda
                fetch("app/controllers/DudasController.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `action=delete&id_duda=${idDuda}`,
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Duda eliminada correctamente.");
                            // Eliminar la fila de la tabla
                            event.target.closest("tr").remove();
                        } else {
                            alert("Error al eliminar la duda: " + data.error);
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Ocurrió un error al intentar eliminar la duda.");
                    });
            }
        }
    });
});