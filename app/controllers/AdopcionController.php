<?php
require_once '../models/Adopcion.php'; 
session_start();

header('Content-Type: application/json'); // Asegura que las respuestas sean JSON

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        // Manejar la acción de agregar un comentario
        if ($action === 'addComment' && isset($_POST['id_adopcion'], $_POST['comentario'])) {
            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception("No tienes permiso para realizar esta acción.");
            }

            $id_adopcion = intval($_POST['id_adopcion']);
            $id_usuario = intval($_SESSION['id_usuario']);
            $comentario = trim($_POST['comentario']);

            if (!empty($comentario)) {
                if (Adopcion::agregarComentario($id_adopcion, $id_usuario, $comentario)) {
                    echo json_encode(["success" => true, "message" => "Comentario agregado correctamente."]);
                } else {
                    throw new Exception("Error al agregar el comentario.");
                }
            } else {
                throw new Exception("El comentario no puede estar vacío.");
            }
        }

        // Manejar la acción de agregar una adopción
        if ($action === 'add') {
            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception("No tienes permiso para realizar esta acción.");
            }

            $nombre_mascota = $_POST['nombre_mascota'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $edad = intval($_POST['edad'] ?? 0);
            $estado_salud = $_POST['estado_salud'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $id_usuario = intval($_SESSION['id_usuario']);

            // Manejar la subida de la foto
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $fotoTmp = $_FILES['foto']['tmp_name'];
                $fotoNombre = basename($_FILES['foto']['name']);
                $fotoDestino = "../../public/uploads/" . $fotoNombre;

                if (!move_uploaded_file($fotoTmp, $fotoDestino)) {
                    throw new Exception("Error al subir la foto.");
                }
            } else {
                throw new Exception("La foto es obligatoria.");
            }

            // Guardar la adopción en la base de datos
            if (Adopcion::add($nombre_mascota, $tipo, $edad, $estado_salud, $fotoDestino, $descripcion, $id_usuario)) {
                $_SESSION['success_message'] = "¡La adopción se publicó con éxito!";
                header("Location: ../../index.php?page=adopcion");
                exit;
            } else {
                throw new Exception("Error al guardar la adopción.");
            }
        }

        // Manejar la acción de cambiar el estado de la adopción
        if ($action === 'updateStatus' && isset($_POST['id_adopcion'], $_POST['estado'])) {
            $id_adopcion = intval($_POST['id_adopcion']);
            $estado = $_POST['estado'];

            if (Adopcion::updateEstado($id_adopcion, $estado)) {
                echo json_encode(["success" => true, "message" => "Estado actualizado correctamente."]);
            } else {
                throw new Exception("Error al actualizar el estado de la adopción.");
            }
        }

        // Manejar la acción de eliminar una adopción
        if ($action === 'delete' && isset($_POST['id_adopcion'])) {
            $id_adopcion = intval($_POST['id_adopcion']);

            if (Adopcion::delete($id_adopcion)) {
                echo json_encode(["success" => true, "message" => "Adopción eliminada correctamente."]);
            } else {
                throw new Exception("Error al eliminar la adopción.");
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id_adopcion'])) {
            $id_adopcion = intval($_GET['id_adopcion']);
            $comentarios = Adopcion::obtenerComentarios($id_adopcion);
            echo json_encode($comentarios);
        } else {
            $adopciones = Adopcion::getAll();
            echo json_encode($adopciones);
        }
    }
} catch (Exception $e) {
    error_log("Error en AdopcionController: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>