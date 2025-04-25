<?php
require_once '../models/FAQ.php';

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' && !empty($_POST['pregunta']) && !empty($_POST['respuesta'])) {
            // Acción para agregar una pregunta frecuente
            if (FAQ::add($_POST['pregunta'], $_POST['respuesta'])) {
                echo json_encode(["success" => true, "message" => "Pregunta frecuente agregada correctamente."]);
            } else {
                throw new Exception("Error al agregar la pregunta frecuente.");
            }
        } elseif ($action === 'delete' && !empty($_POST['id_faq'])) {
            // Acción para eliminar una pregunta frecuente
            $id_faq = intval($_POST['id_faq']);
            if (FAQ::delete($id_faq)) {
                echo json_encode(["success" => true, "message" => "Pregunta frecuente eliminada correctamente."]);
            } else {
                throw new Exception("Error al eliminar la pregunta frecuente.");
            }
        } else {
            throw new Exception("Acción no válida o parámetros incorrectos.");
        }
    } else {
        // Obtener todas las preguntas frecuentes
        echo json_encode(["success" => true, "data" => FAQ::getAll()]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>