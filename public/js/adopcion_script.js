// Función para obtener comentarios desde el controlador
async function obtenerComentarios(idAdopcion) {
    try {
        const response = await fetch(`/ProyectoAW/app/controllers/AdopcionController.php?id_adopcion=${idAdopcion}`);
        if (response.ok) {
            return await response.json();
        } else {
            console.error(`Error al obtener comentarios para la adopción ${idAdopcion}: ${response.status}`);
            return [];
        }
    } catch (error) {
        console.error(`Error al realizar la solicitud para obtener comentarios:`, error);
        return [];
    }
}

// Manejar el evento de clic en los botones de agregar comentario
document.querySelectorAll('.agregar-comentario-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const idAdopcion = this.getAttribute('data-id'); // Obtener el ID de la adopción
        const textarea = document.querySelector(`.comentario-textarea[data-id="${idAdopcion}"]`);
        const comentario = textarea.value.trim(); // Obtener el comentario del usuario

        if (comentario) {
            const formData = new FormData();
            formData.append('action', 'addComment');
            formData.append('id_adopcion', idAdopcion);
            formData.append('comentario', comentario);

            try {
                const response = await fetch('/ProyectoAW/app/controllers/AdopcionController.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Agregar el nuevo comentario a la lista de comentarios
                    const comentariosList = document.getElementById(`comentarios-${idAdopcion}`);
                    const nuevoComentario = document.createElement('li');
                    nuevoComentario.innerHTML = `<strong>Tú:</strong> ${comentario} (Ahora)`;
                    comentariosList.prepend(nuevoComentario);

                    // Limpiar el campo de texto
                    textarea.value = '';
                } else {
                    alert(result.message); // Mostrar mensaje de error
                }
            } catch (error) {
                console.error('Error al agregar el comentario:', error);
                alert('Ocurrió un error al intentar agregar el comentario.');
            }
        } else {
            alert('El comentario no puede estar vacío.');
        }
    });
});

// Cargar comentarios dinámicamente al cargar la página
document.querySelectorAll('.comentarios-list').forEach(async (comentariosList) => {
    const idAdopcion = comentariosList.getAttribute('id').split('-')[1]; // Obtener el ID de la adopción
    const comentarios = await obtenerComentarios(idAdopcion);

    if (comentarios.length > 0) {
        comentarios.forEach(comentario => {
            const nuevoComentario = document.createElement('li');
            nuevoComentario.innerHTML = `<strong>${comentario.nombre_usuario}:</strong> ${comentario.comentario} (${comentario.fecha})`;
            comentariosList.appendChild(nuevoComentario);
        });
    } else {
        const noComentarios = document.createElement('li');
        noComentarios.textContent = 'No hay comentarios aún.';
        comentariosList.appendChild(noComentarios);
    }
});


