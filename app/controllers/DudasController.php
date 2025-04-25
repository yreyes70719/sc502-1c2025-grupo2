<?php
require_once '../models/Duda.php';

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' && !empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['mensaje'])) {
            // Acción para agregar una duda
            if (Duda::add($_POST['nombre'], $_POST['correo'], $_POST['mensaje'])) {
                echo json_encode(["success" => true, "message" => "Duda agregada correctamente."]);
            } else {
                throw new Exception("Error al agregar la duda.");
            }
        } elseif ($action === 'delete' && !empty($_POST['id_duda'])) {
            // Acción para eliminar una duda
            $id_duda = intval($_POST['id_duda']);
            if (Duda::delete($id_duda)) {
                echo json_encode(["success" => true, "message" => "Duda eliminada correctamente."]);
            } else {
                throw new Exception("Error al eliminar la duda.");
            }
        } else {
            throw new Exception("Acción no válida o parámetros incorrectos.");
        }
    } else {
        // Obtener todas las dudas
        echo json_encode(["success" => true, "data" => Duda::getAll()]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>