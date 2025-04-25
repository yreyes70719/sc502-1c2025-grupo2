<?php
require_once '../../config/database.php';

class Reporte
{
    public static function getAll(): array
    {
        global $conn;

        try {
            $sql = "
                SELECT 
                    r.*, 
                    u.correo AS correo_usuario 
                FROM 
                    Reportes r
                JOIN 
                    Usuarios u 
                ON 
                    r.id_usuario = u.id_usuario
            ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (mysqli_sql_exception $e) {
            return ["error" => "Error al obtener reportes: " . $e->getMessage()];
        }
    }

    public static function add($nombre_mascota, $raza, $edad, $ubicacion, $numero_dueno, $detalles, $estado, $imagen, $id_usuario)
    {
        global $conn;

        $sql = "INSERT INTO Reportes (nombre_mascota, raza, edad, ubicacion, numero_dueno, detalles, estado, imagen, id_usuario) 
                VALUES ('$nombre_mascota', '$raza', $edad, '$ubicacion', '$numero_dueno', '$detalles', '$estado', '$imagen', $id_usuario)";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id_reporte)
    {
        global $conn;

        $sql = "DELETE FROM Reportes WHERE id_reporte = $id_reporte";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateStatus($id_reporte, $estado)
    {
        global $conn;

        $sql = "UPDATE Reportes SET estado = '$estado' WHERE id_reporte = $id_reporte";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function agregarComentario($id_reporte, $id_usuario, $comentario)
    {
        global $conn;

        $sql = "INSERT INTO ComentariosReportes (id_reporte, id_usuario, comentario) 
                VALUES ($id_reporte, $id_usuario, '$comentario')";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function obtenerComentarios($id_reporte): array
    {
        global $conn;

        $sql = "SELECT c.comentario, c.fecha, u.nombre_usuario 
                FROM ComentariosReportes c 
                JOIN Usuarios u ON c.id_usuario = u.id_usuario 
                WHERE c.id_reporte = $id_reporte 
                ORDER BY c.fecha DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>