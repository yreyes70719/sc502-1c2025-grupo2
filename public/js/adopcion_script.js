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

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Comentario agregado!',
                        text: 'Tu comentario se agregó correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (error) {
                console.error('Error al agregar el comentario:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al intentar agregar el comentario.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: 'El comentario no puede estar vacío.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});

// Función para cambiar el estado de la adopción
document.querySelectorAll('.cambiar-estado-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const idAdopcion = this.getAttribute('data-id');
        const nuevoEstado = this.getAttribute('data-estado');

        const formData = new FormData();
        formData.append('action', 'updateStatus');
        formData.append('id_adopcion', idAdopcion);
        formData.append('estado', nuevoEstado);

        try {
            const response = await fetch('/ProyectoAW/app/controllers/AdopcionController.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'El estado de la adopción se actualizó correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    location.reload(); // Recargar la página para reflejar los cambios
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: result.message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            console.error('Error al cambiar el estado:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al intentar cambiar el estado.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});

// Función para eliminar una adopción
document.querySelectorAll('.eliminar-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const idAdopcion = this.getAttribute('data-id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la adopción de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id_adopcion', idAdopcion);

                try {
                    const response = await fetch('/ProyectoAW/app/controllers/AdopcionController.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'La adopción se eliminó correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload(); // Recargar la página para reflejar los cambios
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } catch (error) {
                    console.error('Error al eliminar la adopción:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al intentar eliminar la adopción.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
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