<?php
require_once '../../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    if (!empty($correo) && !empty($contraseña)) {
        $sql = "SELECT * FROM Usuarios WHERE correo = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($contraseña, $usuario['contraseña'])) { // Verifica la contraseña con el hash
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                // Establecer mensaje de éxito
                $_SESSION['success_message'] = "Bienvenido, {$usuario['nombre_usuario']}!";

                // Redirigir al home
                header("Location: http://localhost/ProyectoAW/?page=home");
                exit;
            } else {
                // Contraseña incorrecta
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Contraseña incorrecta.',
                        confirmButtonText: 'Intentar de nuevo'
                    }).then(() => {
                        window.location.href = 'http://localhost/ProyectoAW/?page=login';
                    });
                </script>";
                exit;
            }
        } else {
            // Usuario no encontrado
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró una cuenta con ese correo.',
                    confirmButtonText: 'Intentar de nuevo'
                }).then(() => {
                    window.location.href = 'http://localhost/ProyectoAW/?page=login';
                });
                </script>";
            exit;
        }
    } else {
        // Campos vacíos
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, completa todos los campos.',
                confirmButtonText: 'Volver'
            }).then(() => {
                window.location.href = 'http://localhost/ProyectoAW/?page=login';
            });
        </script>";
        exit;
    }
}
?>