<?php
require_once '../models/Adopcion.php'; 
session_start();

header('Content-Type: application/json'); // Asegura que las respuestas sean JSON

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        // Manejar la acción de agregar un comentario
        if ($action === 'addComment' && isset($_POST['id_adopcion'], $_POST['comentario'])) {
            // Validar que el usuario esté logueado
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
            // Obtener comentarios para una adopción específica
            $id_adopcion = intval($_GET['id_adopcion']);
            $comentarios = Adopcion::obtenerComentarios($id_adopcion);
            echo json_encode($comentarios);
        } else {
            // Obtener todas las adopciones
            $adopciones = Adopcion::getAll();
            echo json_encode($adopciones);
        }
    }
} catch (Exception $e) {
    error_log("Error en AdopcionController: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>