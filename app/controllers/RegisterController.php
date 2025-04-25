<?php
require_once '../../config/database.php';
session_start(); // Iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['userName'] ?? '');
    $correo = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $contraseña = $_POST['password'] ?? '';
    $confirmar_contraseña = $_POST['confirm-password'] ?? '';
    $rol = 'Usuario'; // Por defecto, el rol será 'Usuario'

    try {
        // Validar que los campos no estén vacíos
        if (empty($nombre_usuario) || empty($correo) || empty($telefono) || empty($contraseña) || empty($confirmar_contraseña)) {
            throw new Exception("Por favor, completa todos los campos.");
        }

        // Validar que las contraseñas coincidan
        if ($contraseña !== $confirmar_contraseña) {
            throw new Exception("Las contraseñas no coinciden.");
        }

        // Validar que el correo no exista ya en la base de datos
        $sql = "SELECT id_usuario FROM Usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            throw new Exception("El correo ya está registrado.");
        }

        // Validar que el nombre de usuario no exista ya en la base de datos
        $sql = "SELECT id_usuario FROM Usuarios WHERE nombre_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            throw new Exception("El nombre de usuario ya está registrado.");
        }

        // Encriptar la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO Usuarios (nombre_usuario, correo, telefono, contraseña, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nombre_usuario, $correo, $telefono, $contraseña_hash, $rol);

        if ($stmt->execute()) {
            // Obtener el ID del usuario recién registrado
            $id_usuario = $stmt->insert_id;

            // Iniciar la sesión automáticamente
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['rol'] = $rol;

            // Establecer mensaje de éxito
            $_SESSION['success_message'] = "¡Registro exitoso! Bienvenido, {$nombre_usuario}.";

            // Redirigir al inicio con la sesión iniciada
            header("Location: http://localhost/ProyectoAW/?page=home");
            exit;
        } else {
            throw new Exception("Error al registrar el usuario. Inténtalo de nuevo.");
        }
    } catch (Exception $e) {
        // Establecer mensaje de error
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: http://localhost/ProyectoAW/?page=register");
        exit;
    }
}
?>