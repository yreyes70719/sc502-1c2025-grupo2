<?php
require_once '../models/Adopcion.php';

try {
    if (!empty($_POST)) {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' && !empty($_POST['nombre_mascota']) && !empty($_POST['tipo']) && isset($_POST['edad']) && !empty($_POST['estado_salud']) && !empty($_POST['descripcion']) && !empty($_POST['id_usuario']) && isset($_FILES['foto'])) {
            // Manejo del archivo subido
            $foto = $_FILES['foto'];
            $fotoNombre = time() . "_" . basename($foto['name']);
            $fotoRuta = $_SERVER['DOCUMENT_ROOT'] . '/ProyectoAW/public/uploads/' . $fotoNombre;

            if (move_uploaded_file($foto['tmp_name'], $fotoRuta)) {
                // Agregar una nueva adopción
                if (Adopcion::add($_POST['nombre_mascota'], $_POST['tipo'], $_POST['edad'], $_POST['estado_salud'], $fotoNombre, $_POST['descripcion'], $_POST['id_usuario'])) {
                    echo json_encode(["success" => "Adopción agregada correctamente!"]);
                } else {
                    throw new Exception("Error al agregar la adopción.");
                }
            } else {
                throw new Exception("Error al subir la foto.");
            }
        } elseif ($action === 'delete' && !empty($_POST['id_adopcion'])) {
            // Eliminar una adopción
            if (Adopcion::delete($_POST['id_adopcion'])) {
                echo json_encode(["success" => "Adopción eliminada correctamente!"]);
            } else {
                throw new Exception("Error al eliminar la adopción.");
            }
        } elseif ($action === 'updateHealthStatus' && !empty($_POST['id_adopcion']) && !empty($_POST['estado_salud'])) {
            // Actualizar el estado de salud de una adopción
            if (Adopcion::updateHealthStatus($_POST['id_adopcion'], $_POST['estado_salud'])) {
                echo json_encode(["success" => "Estado de salud actualizado correctamente!"]);
            } else {
                throw new Exception("Error al actualizar el estado de salud.");
            }
        } else {
            throw new Exception("Acción no válida o parámetros incorrectos.");
        }
    } else {
        // Obtener todas las adopciones
        $adopciones = Adopcion::getAll();
        echo json_encode($adopciones);
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
