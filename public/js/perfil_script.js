document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos del usuario logueado
    fetch('app/controllers/PerfilController.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                });
            } else {
                const fotoPerfil = document.getElementById('foto-perfil');
                const fotoPlaceholder = document.getElementById('foto-perfil-placeholder');

                if (data.foto_perfil) {
                    fotoPerfil.src = data.foto_perfil;
                    fotoPerfil.style.display = 'block';
                    fotoPlaceholder.style.display = 'none';
                } else {
                    fotoPerfil.style.display = 'none';
                    fotoPlaceholder.style.display = 'flex';
                }

                document.getElementById('nombre').value = data.nombre_usuario || '';
                document.getElementById('correo').value = data.correo || '';
                document.getElementById('telefono').value = data.telefono || '';
                document.getElementById('contrasena-actual').value = '********';
                document.getElementById('contrasena').value = '';
                document.getElementById('confirmar-contrasena').value = '';
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cargar el perfil.',
            });
            console.error('Error al cargar el perfil:', error);
        });

    // Previsualizar la imagen seleccionada
    const fotoInput = document.getElementById('foto');
    const fotoPerfil = document.getElementById('foto-perfil');
    const fotoPlaceholder = document.getElementById('foto-perfil-placeholder');

    fotoInput.addEventListener('change', () => {
        const file = fotoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                fotoPerfil.src = e.target.result;
                fotoPerfil.style.display = 'block';
                fotoPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById('perfil-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const contrasena = document.getElementById('contrasena').value;
    const confirmarContrasena = document.getElementById('confirmar-contrasena').value;

    if (contrasena && contrasena !== confirmarContrasena) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Las contraseñas no coinciden.',
        });
        return;
    }

    const formData = new FormData(this);

    // Agregar la foto de perfil al FormData
    const fotoInput = document.getElementById('foto');
    if (fotoInput.files.length > 0) {
        formData.append('foto', fotoInput.files[0]);
    }

    fetch('app/controllers/PerfilController.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.success,
                });

                // Actualizar la foto de perfil en la página
                if (data.foto_perfil) {
                    document.getElementById('foto-perfil').src = data.foto_perfil;
                    document.getElementById('foto-perfil').style.display = 'block';
                    document.getElementById('foto-perfil-placeholder').style.display = 'none';
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar el perfil.',
            });
            console.error('Error al guardar el perfil:', error);
        });
});