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
            if (password_verify($contraseña, $usuario['contraseña'])) {
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
                $_SESSION['error_message'] = "Contraseña incorrecta. Por favor, inténtalo de nuevo.";
                header("Location: http://localhost/ProyectoAW/?page=login");
                exit;
            }
        } else {
            // Usuario no encontrado
            $_SESSION['error_message'] = "No se encontró una cuenta con ese correo.";
            header("Location: http://localhost/ProyectoAW/?page=login");
            exit;
        }
    } else {
        // Campos vacíos
        $_SESSION['error_message'] = "Por favor, completa todos los campos.";
        header("Location: http://localhost/ProyectoAW/?page=login");
        exit;
    }
}
?>