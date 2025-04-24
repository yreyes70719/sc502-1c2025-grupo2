<?php
require_once '../../config/database.php';
require_once '../models/Usuarios.php';

session_start();

class PerfilController
{
    public static function obtenerPerfil()
    {
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $usuario = Usuario::getById($id_usuario);
            echo json_encode($usuario);
        } else {
            echo json_encode(["error" => "Usuario no autenticado"]);
        }
    }

    public static function actualizarPerfil()
    {
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $contrasena = $_POST['contrasena'];

            // Manejar la carga de la foto
            $foto_perfil = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = '../../public/uploads/';
                $foto_perfil = $upload_dir . basename($_FILES['foto']['name']);

                // Mover el archivo subido a la carpeta de uploads
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_perfil)) {
                    echo json_encode(["error" => "Error al subir la imagen"]);
                    return;
                }

                // Convertir la ruta a una relativa para el cliente
                $foto_perfil = 'public/uploads/' . basename($_FILES['foto']['name']);
            }

            $resultado = Usuario::updateProfile($id_usuario, $nombre, $telefono, $contrasena, $foto_perfil);
            echo json_encode($resultado);
        } else {
            echo json_encode(["error" => "Usuario no autenticado"]);
        }
    }
}

// Manejo de rutas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    PerfilController::obtenerPerfil();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    PerfilController::actualizarPerfil();
}
?>