<?php
require_once '../models/Reporte.php'; 
session_start();

header('Content-Type: application/json'); // Asegura que las respuestas sean JSON

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        // Manejar la acción de agregar un comentario
        if ($action === 'addComment' && isset($_POST['id_reporte'], $_POST['comentario'])) {
            // Validar que el usuario esté logueado
            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception("No tienes permiso para realizar esta acción.");
            }

            $id_reporte = intval($_POST['id_reporte']);
            $id_usuario = intval($_SESSION['id_usuario']);
            $comentario = trim($_POST['comentario']);

            if (!empty($comentario)) {
                if (Reporte::agregarComentario($id_reporte, $id_usuario, $comentario)) {
                    echo json_encode(["success" => true, "message" => "Comentario agregado correctamente."]);
                } else {
                    throw new Exception("Error al agregar el comentario.");
                }
            } else {
                throw new Exception("El comentario no puede estar vacío.");
            }
        }

        // Manejar la acción de agregar un reporte
        if ($action === 'add') {
            // Validar que el usuario esté logueado
            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception("No tienes permiso para realizar esta acción.");
            }

            // Obtener los datos del formulario
            $nombre_mascota = $_POST['nombre_mascota'] ?? '';
            $raza = $_POST['raza'] ?? '';
            $edad = intval($_POST['edad'] ?? 0); 
            $ubicacion = $_POST['ubicacion'] ?? '';
            $numero_dueno = $_POST['numero_dueno'] ?? '';
            $detalles = $_POST['detalles'] ?? '';
            $estado = $_POST['estado'] ?? 'Desaparecido';
            $id_usuario = intval($_SESSION['id_usuario']);

            // Manejar la subida de la imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagenTmp = $_FILES['imagen']['tmp_name'];
                $imagenNombre = basename($_FILES['imagen']['name']);
                $imagenDestino = "../../public/uploads/" . $imagenNombre;

                if (!move_uploaded_file($imagenTmp, $imagenDestino)) {
                    throw new Exception("Error al subir la imagen.");
                }
            } else {
                throw new Exception("La imagen es obligatoria.");
            }

            // Guardar el reporte en la base de datos
            if (Reporte::add($nombre_mascota, $raza, $edad, $ubicacion, $numero_dueno, $detalles, $estado, $imagenNombre, $id_usuario)) {
                // Establecer un mensaje de éxito en la sesión
                $_SESSION['success_message'] = "¡El reporte se publicó con éxito!";
                // Redirigir al sistema de enrutamiento para cargar la página con el layout
                header("Location: ../../index.php?page=reportes");
                exit;
            } else {
                throw new Exception("Error al guardar el reporte.");
            }
        }

        // Manejar la acción de cambiar el estado del reporte
        if ($action === 'updateStatus' && isset($_POST['id_reporte'], $_POST['estado'])) {
            $id_reporte = intval($_POST['id_reporte']);
            $estado = $_POST['estado'];

            if (Reporte::updateStatus($id_reporte, $estado)) {
                echo json_encode(["success" => true, "message" => "Estado actualizado correctamente."]);
            } else {
                throw new Exception("Error al actualizar el estado del reporte.");
            }
        }

        // Manejar la acción de eliminar un reporte
        if ($action === 'delete' && isset($_POST['id_reporte'])) {
            $id_reporte = intval($_POST['id_reporte']);

            if (Reporte::delete($id_reporte)) {
                echo json_encode(["success" => true, "message" => "Reporte eliminado correctamente."]);
            } else {
                throw new Exception("Error al eliminar el reporte.");
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id_reporte'])) {
            // Obtener comentarios para un reporte específico
            $id_reporte = intval($_GET['id_reporte']);
            $comentarios = Reporte::obtenerComentarios($id_reporte);
            echo json_encode($comentarios);
        } else {
            // Obtener todos los reportes
            $reportes = Reporte::getAll();
            echo json_encode($reportes);
        }
    }
} catch (Exception $e) {
    error_log("Error en ReportesController: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>