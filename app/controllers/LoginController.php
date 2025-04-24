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
            if ($contraseña === $usuario['contraseña']) { // Cambiar a password_verify si usas hash
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según el rol
                if ($usuario['rol'] === 'Administrador') {
                    header("Location: http://localhost/ProyectoAW/?page=home"); //cambiar para el admin
                } else {
                    header("Location: http://localhost/ProyectoAW/?page=home");
                }
                exit;
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "No se encontró una cuenta con ese correo.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}

// Mostrar el error si existe
if (isset($error)) {
    echo "<script>alert('$error'); window.location.href='http://localhost/ProyectoAW/?page=login';</script>";
    exit;
}
?>